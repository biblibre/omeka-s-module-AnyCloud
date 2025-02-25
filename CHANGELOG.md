# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## \[v3.0.0\] - 2023-02-19
### Changed
- Upped version number to `v3.0.0`
- Upgraded for Omeka S v4 compatibility
- Updated Flysystem to v3
- Removed Rackspace adapter


## \[v2.0.0\] - 2021-01-04
### Changed
- Upped version number to `v2.0.0`
- Upgraded for Omeka S v3 compatibility
- Updated to latest composer repositories for dependencies

## \[v1.1.5\] - 2020-06-17
### Changed
- Upped version number to `v1.1.5`
- Added public visibility for all S3 Storage adapter cloud items by default (thanks @jajm)

## \[v1.1.4\] - 2020-01-19
### Changed
- Upped version number to `v1.1.4`
- Added `README.md` to binary download

## \[v1.1.3\] - 2019-11-21
### Changed
- Upped version number to `v1.1.3`
- Fixed code style errors
- Made more compatible with PHP 7

## \[v1.1.2\] - 2019-11-20
### Changed
- Upped version number to `v1.1.2`
- Updated `composer` packages
- Fixes issue #10

## \[v1.1.1\] - 2019-08-27
### Changed
- Upped version number to `v1.1.1`
- Fixed style problems from StyleCI

### Added
- Support for Omeka S `^2.0.0`

## \[v1.1.0\] - 2019-05-14
### Changed
- Upped version number to `v1.1.0`
- Updated `README.md` to indicate Wasabi is now a supported cloud storage service
- Fixes issue #7

### Added
- Wasabi Cloud Storage adapter

## \[v1.0.2\] - 2019-05-06
### Changed
- Upped version number to `v1.0.2`
- Fixed style problems from StyleCI
- Fixed javascript loading problem for `toggle.js`
- Updated `README.md` to indicate the module now has a DOI

### Added
- `CONTRIBUTORS.md` file
- DOI for the module

## \[v1.0.1\] - 2019-03-12
### Changed
- Upped version number to `v1.0.1`
- Fixed #4 (thanks @jonfackrell)

## \[v1.0.0\] - 2019-03-12
### Changed
- Fixed `.zip` release to include `Module.php`
- Upped version number to `v1.0.0`

### Added
- Minimum Omeka S version to `module.ini` (may work with earlier versions but only tested on 1.3.0 and up)

## \[v0.3.2\] - 2019-02-07
### Changed
- Upped version number to `v0.3.2`
- Fixed bug when `default` adapter is selected
- Added `README.md` to bundle so description shows up in Omeka’s website

## \[v0.3.1\] - 2019-02-05
### Changed
- Upped version number to `v0.3.1`
- Reduced complexity of `AnyCloudFactory.php`
- Reduced complexity of `ConfigForm.php`
- Fixed markdown style to be consistent

### Added
- Scrutinizer integration
- Code Climate integration
- StyleCI integration

### Removed
- Unused files

## \[v0.3.0\] - 2019-02-03
### Changed
- Upped version number to `v0.3.0`
- Updated `README.md`
- Simplified settings for fewer database entries in `setting` table (breaking change—should be last breaking change for a while)

### Added
- User friendly configuration form for multiple cloud adapters

## \[v0.2.0\] - 2019-01-29
### Removed
- Removed the need for users to manually change the file store alias in `config/local.config.php`

### Changed
- Upped version number to `v0.2.0`
- Updated `README.md`
- Allow settings to be configurable by the user from the Admin side of the system
- Changed the names of variables used to set up adapters (breaking change)
- Moved reused adapter code to a trait (`src/Service/File/Adapter/Common.php`)
- Updated `.gitignore` file to ignore `CHANGELOG.md` when exporting project

### Added
- Added `CHANGELOG.md`
- Added `CODE_OF_CONDUCT.md`
- Added templates for filing issues and requesting features

## \[v0.1.0\] - 2019-01-27
### Added
- Initial release
- Minimally viable module
