# Careerbuilder Jobs Client

[![Latest Version](https://img.shields.io/github/release/JobBrander/jobs-careerbuilder.svg?style=flat-square)](https://github.com/JobBrander/jobs-careerbuilder/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/JobBrander/jobs-careerbuilder/master.svg?style=flat-square&1)](https://travis-ci.org/JobBrander/jobs-careerbuilder)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/JobBrander/jobs-careerbuilder.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-careerbuilder/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/JobBrander/jobs-careerbuilder.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-careerbuilder)
[![Total Downloads](https://img.shields.io/packagist/dt/jobbrander/jobs-careerbuilder.svg?style=flat-square)](https://packagist.org/packages/jobbrander/jobs-careerbuilder)

This package provides [Careerbuilder Job Search API ](http://api.careerbuilder.com/Search/jobsearch/jobsearchinfo.aspx)
support for the JobBrander's [Jobs Client](https://github.com/JobBrander/jobs-common).

## Installation

To install, use composer:

```
composer require jobbrander/jobs-careerbuilder
```

## Usage

Usage is the same as Job Branders's Jobs Client, using `\JobBrander\Jobs\Client\Provider\Careerbuilder` as the provider.

```php
$client = new JobBrander\Jobs\Client\Provider\Careerbuilder([
    'DeveloperKey' => 'YOUR CAREERBUILDER DEVELOPER KEY'
]);

// Search for 200 job listings for 'project manager' in Chicago, IL
$jobs = $client
    // API Parameters
    ->setHostSite('US')             // Two-character code for property being searched. Defaults to 'US'.
    ->setDeveloperKey()    // Required. 20 character long CB API Developer Key.
    ->setAdvancedGroupingMode()    // Optional. Defaults to false. If true, tailors the response format for a grouped search by providing additional grouping metadata. Will only take effect if EnableCompanyCollapse=true or EnableCompanyJobTitleCollapse=true.
    ->setApplyRequirements()    // Optional. Accepts a CSV string value. Limit the search to specific applying requirements. Current valid values: isexternal, canbulkapply, requireuserinfo, hasscreener, hasaoreview, and noonlineapply
    ->setBooleanOperator()    // Optional. Can accept a single value only. Use this param to set change how the keywords are joined together. If no value is provided, defaults to AND. Valid values are: AND, OR.
    ->setCategory()    // Optional. Can accept a single value, or a comma-separated list of values (maximum 10). If the given value(s) do not match any of CareeerBuilder's category names or category codes, this parameter is ignored. We do not attempt any partial matching. Reference the Categories service for a complete list of valid category names and codes. Note to internal CB developers: This parameter also accepts channel codes.
    ->setCoBrand()    // Optional. Some of our existing partners use this param for tracking purposes. If you don't already know what this is, don't worry about it.
    ->setCompanyDID()    // Optional. Accepts a single value. Will limit the Job Search to jobs from the supplied CompanyDID.
    ->setCompanyDIDCSV()    // Optional. Will limit the Job Search to jobs from the supplied CompanyDIDs.
    ->setCompanyName()    // Optional. Accepts a single value. Will limit the Job Search to companies whose names contain the value provided. Use quote-marks if you have multiple words with spaces and want to match the exact string
    ->setCompanyNameBoostParams()    // Optional. Accepts formatted name/weight pairs. Maximum boost weight = 10000, minimum boost weight = 0. Sets company names that the search should favor. Given in this format: companyname1^600~companyname2^400~companyname3^1000.
    ->setCountryCode()    // Optional. Accepts a single two-character value. Will limit the Job Search to the given country.
    ->setEducationCode()    // Optional. Accepts a single value. If the given value does not match one of CareeerBuilder's education codes, this parameter is ignored. By default search results will include results with the requested education code or lower, use the SpecificEducation parameter. Reference the EducationCodes service for a complete list of valid education codes.
    ->setEmpType()    // Optional. Can accept a single value, or a comma-separated list of values. Valid values are variable, depending on what country is being searched. Reference the Employee Types service for a complete list of valid employee types.
    ->setEnableCompanyCollapse()    // Optional. If true, the search results will return grouped by company. This is considered simple grouping mode; the format of the results will not be changed, and no additional metadata about the groups will be returned.
    ->setEnableCompanyJobTitleCollapse()    // Optional. If true, the search results will return grouped by company job title. This is considered simple grouping mode; the format of the results will not be changed, and no additional metadata about the groups will be returned.
    ->setExcludeApplyRequirements()    // Optional. Accepts a CSV string value. Limit the search to exclude specific applying requirements. See ApplyRequirements for valid values.
    ->setExcludeCompanyNames()    // Optional. Accepts a single value or list of comma-separated values. Will limit the Job Search to companies whose names not contain the value(s) provided. Use quote-marks if you have multiple words with spaces and want to match the exact string.
    ->setExcludeJobTitles()    // Optional. Accepts a CSV of job titles. Will limit the Job Search to titles whose names DO NOT contain the values provided. Use quote-marks if you have multiple words with spaces and want to match the exact string.
    ->setExcludeKeywords()    // Optional. Can accept a single value, or a comma-separated list of values. Excludes results that are related to the provided value(s).
    ->setExcludeNational()    // Optional. If true, excludes jobs that have been posted as "nationwide".
    ->setExcludeNonTraditionalJobs()    // Optional. If true, will exclude jobs that have been marked as nontraditional.
    ->setFacetCategory()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a comma-separated list of Job Category values. Will limit the job search to jobs that fall under a particulair category. Acceptable Job Categories codes (http://api.careerbuilder.com/v1/categories)
    ->setFacetCompany()    // Optional. *UseFacets must be set to true for this to be considered* Only accepts a single Company Title that must be encased in double quotes ("Company Name"). Will limit the job search to a particulair company.
    ->setFacetCity()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a comma-separated list of Cities and will limit the job search to that area.
    ->setFacetState()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a comma-separated list of denoted two letter State values and will limit the job search to that area.
    ->setFacetCityState()    // Optional. *UseFacets must be set to true for this to be considered* Only accepts a single value in the form of a City and denoted two letter State value delimited by a comma. This will limit the job search to that area.
    ->setFacetPay()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a single value from the following list:
    ->setFacetRelatedJobTitle()    // Optional. *UseFacets must be set to true for this to be considered* Only accepts a single Job Title. This will limit the job search to return jobs that are categorized under the same/related job title(s).
    ->setFacetCountry()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a list of values in the form of a two letter country code. This will limit the job search to that area.
    ->setFacetEmploymentType()    // Optional. *UseFacets must be set to true for this to be considered* Accepts a comma-separated list of values in the form of an employment type. This will limit the job search to that area.
    ->setIncludeCompanyChildren()    // Optional. If true, the result set will also contain jobs from child companies of the specified company given in the CompanyName, CompanyNameCSV, or CompanyDID params.
    ->setIndustryCodes()    // Optional. Accepts a CSV. Will limit the Job Search to only jobs in the given industries. Accepts a CSV of values returned from v1/industrycodes.
    ->setJobTitle()    // Optional. Accepts a single value. Will return only jobs with the provided job title in their title. Use quote-marks if you have multiple words with spaces and want to match the exact string.
    ->setKeywords()    // Optional. Can accept a single value, or a comma-separated list of values. Will return a results set that is related to the supplied keywords.
    ->setLocation()    // Optional. Can accept a single city name, a single state name, a postal code (as in: 30092), a comma-separated city/state pair (as in: Atlanta, GA), or a latitude and longitude in decimal degree (DD) format (as in 36.7636::-119.7746). If the given location is ambiguous, a list of possible locations will be returned.
    ->setNormalizedCompanyDID()    // Optional. Accepts a single value. Will limit the Job Search to only jobs whose owning companies have been normalized to the given normalized company DID.
    ->setNormalizedCompanyDIDBoostParams()    // Optional. Accepts formatted normalized company DID/weight pairs. Maximum boost weight = 10000, minimum boost weight = 0. Sets normalized companies that the search should favor. Given in this format: normalizedcompanyDID1^600~normalizedcompanyDID2^4000.
    ->setNormalizedCompanyName()    // Optional. Accepts a single value. Will limit the Job Search to only jobs whose owning companies have been normalized to the given normalized company name.
    ->setONetCode()    // Optional. Accepts a single value or CSV; refer to the notes for SingleONetSearch for details about CSV. Will limit the Job Search to jobs related to the given ONet Code. Searches on Major Group, Minor Group, Broad Occupation and Detailed Occuptation. More specific matches are ranked as more relevant in the results. Information about ONet codes
    ->setOrderBy()    // Optional. Can accept a single value only. Use this param to set the ordering of the results. If no value is provided, defaults to Relevance. Valid values are: Date, Pay, Title, Company, Distance, Location, and Relevance. Note: Ordering by Date does not ensure strict date ordering.
    ->setOrderDirection()    // Optional. Can accept a single value only. Use this param to set the direction of the results order. If no value is provided, defaults to descending (generally best to worst). Valid values are: Ascending, ASC, Descending, DESC. Note: Ordering by distance defaults to ascending (nearest to farthest).
    ->setPageNumber()    // Optional. Can accept a single value only. Use this param to retrieve a specific page of results.
    ->setPartnerID()    // Optional. Accepts a single value. Will limit the Job Search to only jobs that fall under the given partner ID.
    ->setPayHigh()    // Optional. This can be used to set a maximum pay level for the search. Values that are acceptable are those that appear on the main CareerBuilder site's advanced job search form.
    ->setPayInfoOnly()    // Optional. If true, then the search results will contain only jobs with pay information.
    ->setPayLow()    // Optional. This can be used to set a minimum pay level for the search. Values that are acceptable are those that appear on the main CareerBuilder site's advanced job search form.
    ->setPerPage()    // Optional. Can accept a single value only. Use this param to set the page size. If no value is provided, defaults to 25.
    ->setPostedWithin()    // Optional. Can accept a single value only. Must be no greater than 30. If no value is provided, defaults to 30. Filters the results list to contain only jobs posted with the provided number of days.
    ->setRadius()    // Optional. The search radius size (in miles) around a specified location. Acceptable values are 5, 10, 20, 30, 50, 100, or 150. A radius of 0 is treated the same as empty. The radius will be the default for the search geography.
    ->setRecordsPerGroup()    // Optional. Sets the number of results per group to return if the search is set to run in either simple or advanced grouping mode. Will have only take effect if EnableCompanyCollapse=true.
    ->setRelocateJobs()    // Optional. If supplied, returns jobs marked 'true' or 'false' for providing relocation assistance. If not supplied, then we search for jobs with 'null' data for relocation assistance (most jobs fall into this category).
    ->setSOCCode()    // Optional. Accepts a single value. Will limit the Job Search to jobs related to the given SOC Code. Searches on Major Group, Minor Group, Broad Occupation and Detailed Occuptation. More specific matches are ranked as more relevant in the results. Information about SOC classification
    ->setSchoolSiteID()    // Optional. Constrains the search to only return jobs marked with the given school site ID.
    ->setSearchAllCountries()    // Optional. If true, the search will not be constrained by CountryCode or HostSite.
    ->setSearchView()    // Optional. Sets the view context in which the search should run.
    ->setShowCategories()    // Optional. If true, a Categories node will be inserted into the response showing which categories each search result was posted under.
    ->setShowApplyRequirements()    // Optional. If true, a ApplyRequirements node will be inserted into the response showing what are required info for applying.
    ->setSingleONetSearch()    // Optional. Will limit the Job Search to jobs marked with the exact given ONet code(s) in the ONetCode parameter. Turns the ONetCode parameter into a CSV. Searches on the exact ONet code(s) ONLY. Information about ONet codes
    ->setSiteEntity()    // Optional. Accepts a single value. Configures the job search with the given site entity.
    ->setSiteID()    // Optional. Some of our existing partners use this param for tracking purposes. If you don't already know what this is, don't worry about it.
    ->setSkills()    // Optional. Accepts a single value or a comma-separated list of values. Filters the search results to contain only jobs marked with the given skills.
    ->setSpecificEducation()    // Optional. If set to true, it will only return results with exactly the EducationCode parameter provided. >If no EducationCode parameter is provided, this parameter is ignored.
    ->setSpokenLanguage()    // Optional. Accepts one of the folowing values ENG (English), FRA (French) or NLD (Dutch)
    ->setTags()    // Optional. Accepts a CSV. Will limit the Job Search to only jobs that are marked with the given tags.
    ->setTalentNetworkDID()    // Optional. Returns jobs that have been marked as part of a given Talent Network.
    ->setUrlCompressionService()    // Optional. Configures a URL compression service to use when constructing links. Accepts bitly or tinyurl.
    ->setUseFacets()    // Optional. If true, a set of facets describing the search results is returned in addition to the set of results.

    // JobBrander Parameters
    ->setKeyword('engineer')        // Can accept a single value, or a comma-separated list of values. Will return a results set that is related to the supplied keywords.
    ->setCity('Pasadena')           // Accepts a comma-separated list of Cities and will limit the job search to that area.
    ->setState('CA')                // Accepts a comma-separated list of denoted two letter State values and will limit the job search to that area.
    ->setPage(2)                    // The page of listings to return. Defaults to 1.
    ->setCount(20)                  // The number of listings per page. The default value is 10. The maximum value is 100.
    ->getJobs();
```

The `getJobs` method will return a [Collection](https://github.com/JobBrander/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/JobBrander/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobbrander/jobs-careerbuilder/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobbrander/jobs-careerbuilder/contributors)

## License

The Apache 2.0. Please see [License File](https://github.com/jobbrander/jobs-careerbuilder/blob/master/LICENSE) for more information.
