# Changelog
All notable changes to this project will be documented in this file.

## [0.2] - 2019-07-17
### Added
- Added a change log to document changes within this project.
- Added a `constants.php` file for allowing users to define their own constants.
- Plugin 2.0 can now access constants like so `{{CONSTANT_NAME}}` in the `themes` folder.
- Default constants are
	- `{{TITLE}}` which accesses Plugin 2.0's title
	- `{{AUTHOR}}` which displays the author of Plugin 2.0's link
	- `{{SEPARATOR}}` which displays the dash separator
	- `{{LINK}}` which displays the current link that this project is sitting in

### Changed
- Changed `defaultTemplate` and `dynamicTemplate` functions to look for user defined constants.

## [0.1] - 2018-10-27
### Initial Release