<?php

namespace AnyCloud;

use AnyCloud\Form\Configform;
use Omeka\Module\AbstractModule;
use Omeka\Module\Exception\ModuleCannotInstallException;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\View\Renderer\PhpRenderer;
use Zend\Mvc\MvcEvent;

class Module extends AbstractModule
{
    public $adapter;

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        parent::onBootstrap($event);
        $this->setFileStoreAlias();
        require __DIR__.'/vendor/autoload.php'; // Add autoloader for module-specific requirements
    }

    /**
     * Generate user messages in case of install problems
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function install(ServiceLocatorInterface $serviceLocator)
    {
        if (!file_exists(__DIR__.'/vendor/autoload.php')) {
            throw new ModuleCannotInstallException('The Any Cloud components via composer should be installed. See module’s installation documentation.');
        }
        $settings = $serviceLocator->get('Omeka\Settings');
        $this->manageSettings($settings, 'install');
    }

    /**
     * Uninstall module and settings
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Omeka\Settings');
        $this->manageSettings($settings, 'uninstall');
    }

    /**
     * Script to run when upgrading module
     *
     * @param string                  $oldVersion
     * @param string                  $newVersion
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function upgrade($oldVersion, $newVersion, ServiceLocatorInterface $serviceLocator)
    {
        require_once 'data/scripts/upgrade.php';
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $services        = $this->getServiceLocator();
        $config          = $services->get('Config');
        $settings        = $services->get('Omeka\Settings');
        $form            = $services->get('FormElementManager')->get(ConfigForm::class);
        $data            = [];
        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        foreach ($defaultSettings as $name => $value) {
            $data[$name] = $settings->get($name, $value);
        }
        $form->init();
        $form->setData($data);
        $html = $renderer->render('anycloud/module/config', [
            'form' => $form,
        ]);

        return $html;
    }

    public function handleConfigForm(AbstractController $controller)
    {
        $serviceLocator = $this->getServiceLocator();
        $settings       = $serviceLocator->get('Omeka\Settings');
        $form           = $serviceLocator->get('FormElementManager')->get(ConfigForm::class);
        $params         = $controller->getRequest()->getPost();
        $form->init();
        $form->setData($params);
        if (!$form->isValid()) {
            $controller->messenger()->addErrors($form->getMessages());

            return false;
        }
        $params          = $form->getData();
        $defaultSettings = $this->getDefaultSettings();
        $params          = array_intersect_key($params, $defaultSettings);
        foreach ($params as $name => $value) {
            $settings->set($name, $value);
        }
    }

    /**
     * Manage module settings
     *
     * @param ServiceLocatorInterface $settings Object containing Omeka settings
     * @param string                  $process  Process used to manage setting (`install` or `uninstall`)
     * @param string                  $key      Name of $settings key to manage
     */
    protected function manageSettings($settings, $process, $key = 'config')
    {
        $defaultSettings = $this->getDefaultSettings($key);
        foreach ($defaultSettings as $name => $value) {
            switch ($process) {
                case 'install':
                    $settings->set(strtolower(__NAMESPACE__).'_'.$name, $value);
                    break;
                case 'uninstall':
                    $settings->delete(strtolower(__NAMESPACE__).'_'.$name);
                    break;
            }
        }
    }

    /**
     * Override default file store alias to use Any Cloud module for uploads instead
     */
    private function setFileStoreAlias()
    {
        $serviceLocator = $this->getServiceLocator();
        $settings       = $serviceLocator->get('Omeka\Settings');
        $this->adapter  = $settings->get('anycloud_adapter');
        if (isset($this->adapter) && $this->adapter !== 'default') {
            $serviceLocator->setAlias('Omeka\File\Store', File\Store\AnyCloud::class);
        }
    }

    private function getDefaultSettings($key = 'config')
    {
        $serviceLocator = $this->getServiceLocator();
        // TODO Fix so that configs are actually grabbed and the module can be deleted if desired
        $config         = $serviceLocator->get('Config');

        return $config[strtolower(__NAMESPACE__)][$key];
    }
}
