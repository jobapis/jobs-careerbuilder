<?php namespace JobApis\Jobs\Client\Queries;

use JobApis\Jobs\Client\Job;

class CareerbuilderQuery extends AbstractProvider
{
    /**
     * Default return attributes
     *
     * @var array
     */
    protected $defaultAttributes = [
        'Company',
        'CompanyDetailsURL',
        'DescriptionTeaser',
        'DID',
        'OnetCode',
        'ONetFriendlyTitle',
        'EmploymentType',
        'EducationRequired',
        'ExperienceRequired',
        'JobDetailsURL',
        'Location',
        'City',
        'State',
        'PostedDate',
        'Pay',
        'JobTitle',
        'CompanyImageURL',
        'Skills',
    ];

    /**
     * Map of setter methods to query parameters
     *
     * @var array
     */
    protected $queryMap = [
        'setDeveloperKey' => 'DeveloperKey',
        'setAdvancedGroupingMode' => 'AdvancedGroupingMode',
        'setApplyRequirements' => 'ApplyRequirements',
        'setBooleanOperator' => 'BooleanOperator',
        'setCategory' => 'Category',
        'setCity' => 'FacetCity',
        'setCoBrand' => 'CoBrand',
        'setCompanyDID' => 'CompanyDID',
        'setCompanyDIDCSV' => 'CompanyDIDCSV',
        'setCompanyName' => 'CompanyName',
        'setCompanyNameBoostParams' => 'CompanyNameBoostParams',
        'setCount' => 'PerPage',
        'setCountryCode' => 'CountryCode',
        'setEducationCode' => 'EducationCode',
        'setEmpType' => 'EmpType',
        'setEnableCompanyCollapse' => 'EnableCompanyCollapse',
        'setEnableCompanyJobTitleCollapse' => 'EnableCompanyJobTitleCollapse',
        'setExcludeApplyRequirements' => 'ExcludeApplyRequirements',
        'setExcludeCompanyNames' => 'ExcludeCompanyNames',
        'setExcludeJobTitles' => 'ExcludeJobTitles',
        'setExcludeKeywords' => 'ExcludeKeywords',
        'setExcludeNational' => 'ExcludeNational',
        'setExcludeNonTraditionalJobs' => 'ExcludeNonTraditionalJobs',
        'setFacetCategory' => 'FacetCategory',
        'setFacetCompany' => 'FacetCompany',
        'setFacetCity' => 'FacetCity',
        'setFacetState' => 'FacetState',
        'setFacetCityState' => 'FacetCityState',
        'setFacetPay' => 'FacetPay',
        'setFacetRelatedJobTitle' => 'FacetRelatedJobTitle',
        'setFacetCountry' => 'FacetCountry',
        'setFacetEmploymentType' => 'FacetEmploymentType',
        'setHostSite' => 'HostSite',
        'setIncludeCompanyChildren' => 'IncludeCompanyChildren',
        'setIndustryCodes' => 'IndustryCodes',
        'setJobTitle' => 'JobTitle',
        'setKeywords' => 'Keywords',
        'setKeyword' => 'Keywords',
        'setLocation' => 'Location',
        'setNormalizedCompanyDID' => 'NormalizedCompanyDID',
        'setNormalizedCompanyDIDBoostParams' => 'NormalizedCompanyDIDBoostParams',
        'setNormalizedCompanyName' => 'NormalizedCompanyName',
        'setONetCode' => 'ONetCode',
        'setOrderBy' => 'OrderBy',
        'setOrderDirection' => 'OrderDirection',
        'setPage' => 'PageNumber',
        'setPageNumber' => 'PageNumber',
        'setPartnerID' => 'PartnerID',
        'setPayHigh' => 'PayHigh',
        'setPayInfoOnly' => 'PayInfoOnly',
        'setPayLow' => 'PayLow',
        'setPerPage' => 'PerPage',
        'setPostedWithin' => 'PostedWithin',
        'setRadius' => 'Radius',
        'setRecordsPerGroup' => 'RecordsPerGroup',
        'setRelocateJobs' => 'RelocateJobs',
        'setSOCCode' => 'SOCCode',
        'setSchoolSiteID' => 'SchoolSiteID',
        'setSearchAllCountries' => 'SearchAllCountries',
        'setSearchView' => 'SearchView',
        'setShowCategories' => 'ShowCategories',
        'setShowApplyRequirements' => 'ShowApplyRequirements',
        'setSingleONetSearch' => 'SingleONetSearch',
        'setSiteEntity' => 'SiteEntity',
        'setSiteID' => 'SiteID',
        'setSkills' => 'Skills',
        'setSpecificEducation' => 'SpecificEducation',
        'setSpokenLanguage' => 'SpokenLanguage',
        'setState' => 'FacetState',
        'setTags' => 'Tags',
        'setTalentNetworkDID' => 'TalentNetworkDID',
        'setUrlCompressionService' => 'UrlCompressionService',
        'setUseFacets' => 'UseFacets',
    ];

    /**
     * Current api query parameters
     *
     * @var array
     */
    protected $queryParams = [
        'DeveloperKey' => null,
        'AdvancedGroupingMode' => null,
        'ApplyRequirements' => null,
        'BooleanOperator' => null,
        'Category' => null,
        'CoBrand' => null,
        'CompanyDID' => null,
        'CompanyDIDCSV' => null,
        'CompanyName' => null,
        'CompanyNameBoostParams' => null,
        'CountryCode' => null,
        'EducationCode' => null,
        'EmpType' => null,
        'EnableCompanyCollapse' => 'true',
        'EnableCompanyJobTitleCollapse' => null,
        'ExcludeApplyRequirements' => null,
        'ExcludeCompanyNames' => null,
        'ExcludeJobTitles' => null,
        'ExcludeKeywords' => null,
        'ExcludeNational' => null,
        'ExcludeNonTraditionalJobs' => null,
        'FacetCategory' => null,
        'FacetCompany' => null,
        'FacetCity' => null,
        'FacetState' => null,
        'FacetCityState' => null,
        'FacetPay' => null,
        'FacetRelatedJobTitle' => null,
        'FacetCountry' => null,
        'FacetEmploymentType' => null,
        'HostSite' => 'US',
        'IncludeCompanyChildren' => null,
        'IndustryCodes' => null,
        'JobTitle' => null,
        'Keywords' => null,
        'Location' => null,
        'NormalizedCompanyDID' => null,
        'NormalizedCompanyDIDBoostParams' => null,
        'NormalizedCompanyName' => null,
        'ONetCode' => null,
        'OrderBy' => null,
        'OrderDirection' => null,
        'PageNumber' => null,
        'PartnerID' => null,
        'PayHigh' => null,
        'PayInfoOnly' => null,
        'PayLow' => null,
        'PerPage' => null,
        'PostedWithin' => null,
        'Radius' => null,
        'RecordsPerGroup' => null,
        'RelocateJobs' => null,
        'SOCCode' => null,
        'SchoolSiteID' => null,
        'SearchAllCountries' => null,
        'SearchView' => null,
        'ShowCategories' => null,
        'ShowApplyRequirements' => null,
        'SingleONetSearch' => null,
        'SiteEntity' => null,
        'SiteID' => null,
        'Skills' => null,
        'SpecificEducation' => null,
        'SpokenLanguage' => null,
        'Tags' => null,
        'TalentNetworkDID' => null,
        'UrlCompressionService' => null,
        'UseFacets' => 'true',
    ];

    /**
     * Create new Careerbuilder jobs client.
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        parent::__construct($parameters);
        array_walk($parameters, [$this, 'updateQuery']);
    }

    /**
     * Magic method to handle get and set methods for properties
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (isset($this->queryMap[$method], $parameters[0])) {
            $this->updateQuery($parameters[0], $this->queryMap[$method]);
        }
        return parent::__call($method, $parameters);
    }

    /**
     * Returns the standardized job object
     *
     * @param array $payload Raw job payload from the API
     *
     * @return \JobBrander\Jobs\Client\Job
     */
    public function createJobObject($payload = [])
    {
        $payload = static::parseAttributeDefaults($payload, $this->defaultAttributes);

        $job = new Job([
            'description' => $payload['DescriptionTeaser'],
            'employmentType' => $payload['EmploymentType'],
            'title' => $payload['JobTitle'],
            'name' => $payload['JobTitle'],
            'url' => $payload['JobDetailsURL'],
            'educationRequirements' => $payload['EducationRequired'],
            'experienceRequirements' => $payload['ExperienceRequired'],
            'sourceId' => $payload['DID'],
        ]);

        $pay = $this->parseSalariesFromString($payload['Pay']);

        $job->setOccupationalCategoryWithCodeAndTitle(
            $payload['OnetCode'],
            $payload['ONetFriendlyTitle']
        )->setCompany($payload['Company'])
            ->setCompanyUrl($payload['CompanyDetailsURL'])
            ->setLocation($payload['City'].', '.$payload['State'])
            ->setCity($payload['City'])
            ->setState($payload['State'])
            ->setDatePostedAsString($payload['PostedDate'])
            ->setCompanyLogo($payload['CompanyImageURL'])
            ->setMinimumSalary($pay['min'])
            ->setMaximumSalary($pay['max']);

        if (isset($payload['Skills']['Skill'])) {
            $job->setSkills($this->parseSkillSet($payload['Skills']['Skill']));
        }

        return $job;
    }

    /**
     * Get data format
     *
     * @return string
     */
    public function getFormat()
    {
        return 'xml';
    }

    /**
     * Get listings path
     *
     * @return string
     */
    public function getListingsPath()
    {
        return 'Results.JobSearchResult';
    }

    /**
     * Get query string for client based on properties
     *
     * @return string
     */
    public function getQueryString()
    {
        return http_build_query($this->queryParams);
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        $queryString = $this->getQueryString();
        return 'http://api.careerbuilder.com/v2/jobsearch/?'.$queryString;
    }

    /**
     * Get http verb
     *
     * @return string
     */
    public function getVerb()
    {
        return 'GET';
    }

    /**
     * Get min and max salary numbers from string
     *
     * @return array
     */
    public function parseSalariesFromString($input = null)
    {
        $salary = [
            'min' => null,
            'max' => null
        ];
        $expressions = [
            'annualRange' => "/^.\d+k\s-\s.\d+k\/year$/",
            'annualFixed' => "/^.\d+k\/year$/",
            'hourlyRange' => "/^.\d+.\d+\s-\s.\d+.\d+\/hour$/",
            'hourlyFixed' => "/^.\d+.\d+\/hour$/",
        ];

        foreach ($expressions as $key => $expression) {
            if (preg_match($expression, $input)) {
                $method = 'parse'.$key;
                $salary = $this->$method($salary, $input);
            }
        }

        return $salary;
    }

    /**
     * Parse annual salary range from CB API
     *
     * @return array
     */
    protected function parseAnnualRange($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+k)\s.\s(.\d+k)/", function ($matches) use (&$salary) {
            $salary['min'] = str_replace('k', '000', $matches[1]);
            $salary['max'] = str_replace('k', '000', $matches[2]);
        }, $input);

        return $salary;
    }

    /**
     * Parse fixed annual salary from CB API
     *
     * @return array
     */
    protected function parseAnnualFixed($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+k)/", function ($matches) use (&$salary) {
            $salary['min'] = str_replace('k', '000', $matches[1]);
        }, $input);

        return $salary;
    }

    /**
     * Parse hourly payrate range from CB API
     *
     * @return array
     */
    protected function parseHourlyRange($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+.\d+)\s.\s(.\d+.\d+)/", function ($matches) use (&$salary) {
            $salary['min'] = $matches[1];
            $salary['max'] = $matches[2];
        }, $input);

        return $salary;
    }

    /**
     * Parse fixed hourly payrate from CB API
     *
     * @return array
     */
    protected function parseHourlyFixed($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+.\d+)/", function ($matches) use (&$salary) {
            $salary['min'] = $matches[1];
        }, $input);

        return $salary;
    }

    /**
     * Parse skills array into string
     *
     * @return array
     */
    protected function parseSkillSet($skills)
    {
        if (is_array($skills)) {
            return implode(', ', $skills);
        } elseif (is_string($skills)) {
            return $skills;
        }
        return null;
    }

    /**
     * Attempts to update current query parameters.
     *
     * @param  string  $value
     * @param  string  $key
     *
     * @return Careerbuilder
     */
    protected function updateQuery($value, $key)
    {
        if (array_key_exists($key, $this->queryParams)) {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }
}
