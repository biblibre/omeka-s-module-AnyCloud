<?php

namespace AnyCloud\Form;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;

class ConfigForm extends Form
{
    
    protected $globalSettings;
    
    /**
     * Initialize the configuration form.
     */
    public function init()
    {
        $this->addAdapter();
        $this->addS3('aws', 'Amazon S3 Storage');
        $this->addAzure();
        $this->addGoogle();
        $this->addS3('digital_ocean', 'DigitalOcean Spaces', 'DigitalOcean');
        $this->addS3('scaleway', 'Scaleway Object Storage', 'Scaleway');
        $this->addRackspace();
        $this->addDropbox();
    }
    
     /**
     * Set configuration settings.
     */
    public function setGlobalSettings($globalSettings)
    {
        $this->globalSettings = $globalSettings;
    }

    /**
     * Add adapter drop-down options to configuration form.
     */
    private function addAdapter()
    {
        $this->add([
            'name'    => 'anycloud_adapter',
            'type'    => Fieldset::class,
            'options' => [
                'label' => 'Any Cloud Adapter',
            ],
            'attributes' => [
                'id' => 'adapter-fieldset',
            ],
        ]);
        $adapterFieldset = $this->get('anycloud_adapter');
        $adapterFieldset->add([
            'name'    => 'adapter',
            'type'    => Element\Select::class,
            'options' => [
                'label'         => 'Cloud Service Adapter: ',
                'value_options' => [
                    'default'       => 'Omeka Default (local server)',
                    'aws'           => 'Amazon S3 Storage',
                    'azure'         => 'Microsoft Azure Storage',
                    'google'        => 'Google Cloud Storage',
                    'digital_ocean' => 'DigitalOcean Spaces',
                    'scaleway'      => 'Scaleway Object Storage',
                    'rackspace'     => 'Rackspace Files',
                    'dropbox'       => 'Dropbox',
                ],
            ],
            'attributes' => [
                'id' => 'adapter',
            ],
        ]);
    }

    /**
     * Add any Amazon S3-based storage adapter.
     *
     * @param string      $id    ID used to identify adapter
     * @param string      $name  Full name of adapter
     * @param string|null $label Abbreviated name used for form labels
     */
    private function addS3($id, $name, $label = null)
    {
        $label = $label === null ? $label : $label.' ';
        $this->add([
            'name'    => 'anycloud_'.$id,
            'type'    => Fieldset::class,
            'options' => [
                'label' => $name,
            ],
            'attributes' => [
                'class' => $id.' fieldset',
            ],
        ]);
        $awsFieldset = $this->get('anycloud_'.$id);
        $awsFieldset->add([
            'name'    => $id.'_key',
            'type'    => Element\Text::class,
            'options' => [
                'label' => $label.'AWS Key',
            ],
            'attributes' => [
                'id' => $id.'_key',
            ],
        ]);
        $awsFieldset->add([
            'name'    => $id.'_secret_key',
            'type'    => Element\Text::class,
            'options' => [
                'label' => $label.'AWS Secret Key',
            ],
            'attributes' => [
                'id'   => $id.'_secret_key',
                'cols' => '100',
            ],
        ]);
        $awsFieldset->add([
            'name'    => $id.'_bucket',
            'type'    => Element\Text::class,
            'options' => [
                'label' => $label.'AWS Bucket',
            ],
            'attributes' => [
                'id' => $id.'_bucket',
            ],
        ]);
        $awsFieldset->add([
            'name'    => $id.'_region',
            'type'    => Element\Text::class,
            'options' => [
                'label' => $label.'AWS Region',
            ],
            'attributes' => [
                'id' => $id.'_region',
            ],
        ]);
        $awsFieldset->add([
            'name'    => $id.'_endpoint',
            'type'    => Element\Text::class,
            'options' => [
                'label' => $label.'AWS Endpoint',
                'info'  => 'Can usually leave blank unless you have a custom endpoint set up. See https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region',
            ],
            'attributes' => [
                'id' => $id.'_endpoint',
            ],
        ]);
    }

    /**
     * Add Microsoft Azure Storage options to configuration form.
     */
    private function addAzure()
    {
        $this->add([
            'name'    => 'anycloud_azure',
            'type'    => Fieldset::class,
            'options' => [
                'label' => 'Microsoft Azure Storage',
            ],
            'attributes' => [
                'class' => 'azure fieldset',
            ],
        ]);
        $azureFieldset = $this->get('anycloud_azure');
        $azureFieldset->add([
            'name'    => 'azure_account_name',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Azure Account Name',
            ],
            'attributes' => [
                'id' => 'azure_account_name',
            ],
        ]);
        $azureFieldset->add([
            'name'    => 'azure_account_key',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Azure Account Key',
            ],
            'attributes' => [
                'id' => 'azure_account_key',
            ],
        ]);
        $azureFieldset->add([
            'name'    => 'azure_container_name',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Azure Container Name',
            ],
            'attributes' => [
                'id' => 'azure_container_name',
            ],
        ]);
        $azureFieldset->add([
            'name'    => 'azure_endpoint',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Azure Endpoint',
                'info'  => 'Can usually leave blank unless you have a custom endpoint set up',
            ],
            'attributes' => [
                'id' => 'azure_endpoint',
            ],
        ]);
    }

    /**
     * Add Google Cloud Storage options to configuration form.
     */
    private function addGoogle()
    {
        $this->add([
            'name'    => 'anycloud_google',
            'type'    => Fieldset::class,
            'options' => [
                'label' => 'Google Cloud Storage',
            ],
            'attributes' => [
                'class' => 'google fieldset',
            ],
        ]);
        $googleFieldset = $this->get('anycloud_google');
        $googleFieldset->add([
            'name'    => 'google_project_id',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Google Project ID',
            ],
            'attributes' => [
                'id' => 'google_project_id',
            ],
        ]);
        $googleFieldset->add([
            'name'    => 'google_bucket_name',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Google Bucket Name',
            ],
            'attributes' => [
                'id' => 'google_bucket_name',
            ],
        ]);
        $googleFieldset->add([
            'name'    => 'google_credentials_path',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Google Credentials Path',
                'info'  => 'Replace {CONFIG} with the name of your Google credentials file stored at the listed path',
                'value' => '/src/Service/File/Adapter/Google/{CONFIG}.json',
            ],
            'attributes' => [
                'id' => 'google_credentials_path',
            ],
        ]);
        $googleFieldset->add([
            'name'    => 'google_storage_uri',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Google Storage URI',
                'info'  => 'You can usually leave this as the default unless you have tweaked other settings',
                'value' => 'https://storage.googleapis.com',
            ],
            'attributes' => [
                'id' => 'google_storage_uri',
            ],
        ]);
    }

    /**
     * Add Rackspace Files options to configuration form.
     */
    private function addRackspace()
    {
        $this->add([
            'name'    => 'anycloud_rackspace',
            'type'    => Fieldset::class,
            'options' => [
                'label' => 'Rackspace Files',
            ],
            'attributes' => [
                'class' => 'rackspace fieldset',
            ],
        ]);
        $rackspaceFieldset = $this->get('anycloud_rackspace');
        $rackspaceFieldset->add([
            'name'    => 'rackspace_identity_endpoint',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Rackspace Identity Endpoint',
                'info'  => 'Valid options include “US_IDENTITY_ENDPOINT” and “UK_IDENTITY_ENDPOINT”',
            ],
            'attributes' => [
                'id' => 'rackspace_identity_endpoint',
            ],
        ]);
        $rackspaceFieldset->add([
            'name'    => 'rackspace_username',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Rackspace Username',
            ],
            'attributes' => [
                'id' => 'rackspace_username',
            ],
        ]);
        $rackspaceFieldset->add([
            'name'    => 'rackspace_password',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Rackspace Password',
            ],
            'attributes' => [
                'id' => 'rackspace_password',
            ],
        ]);
        $rackspaceFieldset->add([
            'name'    => 'rackspace_container',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Rackspace Container Name',
            ],
            'attributes' => [
                'id' => 'rackspace_container',
            ],
        ]);
        $rackspaceFieldset->add([
            'name'    => 'rackspace_region',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Rackspace Region',
            ],
            'attributes' => [
                'id' => 'rackspace_region',
            ],
        ]);
    }

    /**
     * Add Dropbox options to configuration form.
     */
    private function addDropbox()
    {
        $this->add([
            'name'    => 'anycloud_dropbox',
            'type'    => Fieldset::class,
            'options' => [
                'label' => 'Dropbox',
            ],
            'attributes' => [
                'class' => 'dropbox fieldset',
            ],
        ]);
        $dropboxFieldset = $this->get('anycloud_dropbox');
        $dropboxFieldset->add([
            'name'    => 'dropbox_access_token',
            'type'    => Element\Text::class,
            'options' => [
                'label' => 'Dropbox Access Token',
            ],
            'attributes' => [
                'id' => 'dropbox_access_token',
            ],
        ]);
    }
}
