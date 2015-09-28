# Changelog
All Notable changes to `jobs-careerbuilder` will be documented in this file

## 1.0.0 - 2015-09-27

### Added
- Support for all setter methods outlined in the [Careerbuilder API](http://api.careerbuilder.com/Search/jobsearch/jobsearchinfo.aspx)
- Readme documentation for all supported methods
- Tests to support all new methods

### Deprecated
- Public methods for parsing range/fixed salaries made protected

### Fixed
- Sorting methods alphabetically
- Travis-ci support for PHP 7.0 and HHVM

### Removed
- Public "getSkillSet" replaced with protected "parseSkillSet" method

### Security
- Nothing

## 0.2.0 - 2015-09-27

### Added
- Salary range to attribute conversion methods

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.1.5 - 2015-08-12

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Using jobs-common 1.0.3

### Removed
- Nothing

### Security
- Nothing

## 0.1.4 - 2015-07-25

### Added
- Job listing name and title both set
- Using setCompany method to set company name
- Using setMinimumSalary method to set salary

### Deprecated
- Nothing

### Fixed
- Single skill returned from API bug
- Standardizing location format

### Removed
- Nothing

### Security
- Nothing

## 0.1.3 - 2015-07-23

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Minor code quality improvements

### Removed
- Nothing

### Security
- Nothing

## 0.1.2 - 2015-07-04

### Added
- Support for version 1.0 release of jobs-common project

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.1.1 - 2015-06-07

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Fixed tests for upgrade to guzzle 6

### Removed
- Nothing

### Security
- Nothing

## 0.1.0 - 2015-05-21

### Added
- Initial release

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
