<?php namespace JobBrander\Jobs\Client\Providers;

use JobBrander\Jobs\Client\Job;

class Careerbuilder extends AbstractProvider
{
    /**
     * Developer Key
     *
     * @var string
     */
    protected $developerKey;

    /**
     * Host Site
     *
     * @var string
     */
    protected $hostSite;

    /**
     * Use Facets (for city/state)
     *
     * @var string
     */
    protected $useFacets;

    /**
     * Enable Company Collapse (must be true to set count)
     *
     * @var string
     */
    protected $enableCompanyCollapse;

    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return \JobBrander\Jobs\Client\Job
     */
    public function createJobObject($payload)
    {
        $defaults = [
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
            'PostedTime',
            'Pay',
            'JobTitle',
            'CompanyImageURL',
            'Skills',
        ];

        $payload = static::parseAttributeDefaults($payload, $defaults);

        $job = new Job([
            'description' => $payload['DescriptionTeaser'],
            'employmentType' => $payload['EmploymentType'],
            'title' => $payload['JobTitle'],
            'url' => $payload['JobDetailsURL'],
            'company' => $payload['Company'],
            'location' => $payload['Location'],
            'educationRequirements' => $payload['EducationRequired'],
            'experienceRequirements' => $payload['ExperienceRequired'],
            'minimumSalary' => $payload['Pay'],
            'sourceId' => $payload['DID'],
        ]);

        $job->setOccupationalCategoryWithCodeAndTitle(
                $payload['OnetCode'],
                $payload['ONetFriendlyTitle'])
            ->setCompanyUrl($payload['CompanyDetailsURL'])
            ->setCity($payload['City'])
            ->setState($payload['State'])
            ->setDatePostedAsString($payload['PostedTime'])
            ->setCompanyLogo($payload['CompanyImageURL']);

        if (isset($payload['Skills']['Skill'])) {
            $job->setSkills(implode(', ', $payload['Skills']['Skill']));
        }

        return $job;
    }

    /**
     * Get host site
     *
     * @return string
     */
    public function getHostSite()
    {
        return 'US';
    }

    /**
     * Get Use Facets
     *
     * @return string
     */
    public function getUseFacets()
    {
        return 'true';
    }

    /**
     * Get Enable Company Collapse
     *
     * @return string
     */
    public function getEnableCompanyCollapse()
    {
        return 'true';
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
     * @return  string
     */
    public function getListingsPath()
    {
        return 'Results.JobSearchResult';
    }

    /**
     * Get parameters
     *
     * @return  array
     */
    public function getParameters()
    {
        return [];
    }

    /**
     * Get query string for client based on properties
     *
     * @return string
     */
    public function getQueryString()
    {
        $query_params = [
            'DeveloperKey' => 'getDeveloperKey',
            'Keywords' => 'getKeyword',
            'FacetState' => 'getState',
            'FacetCity' => 'getCity',
            'PageNumber' => 'getPage',
            'PerPage' => 'getCount',
            'UseFacets' => 'getUseFacets',
            'EnableCompanyCollapse' => 'getEnableCompanyCollapse',
        ];

        $query_string = [];

        array_walk($query_params, function ($value, $key) use (&$query_string) {
            $computed_value = $this->$value();
            if (!is_null($computed_value)) {
                $query_string[$key] = $computed_value;
            }
        });

        return http_build_query($query_string);
    }

    /**
     * Get url
     *
     * @return  string
     */
    public function getUrl()
    {
        $query_string = $this->getQueryString();

        return 'http://api.careerbuilder.com/v2/jobsearch/?'.$query_string;
    }

    /**
     * Get http verb
     *
     * @return  string
     */
    public function getVerb()
    {
        return 'GET';
    }

    /**
     * Makes the api call and returns a collection of job objects
     *
     * @return  JobBrander\Jobs\Client\Collection
     */
    public function getJobs()
    {
        $client = $this->client;
        $verb = strtolower($this->getVerb());
        $url = $this->getUrl();
        $options = $this->getHttpClientOptions();

        $response = $client->{$verb}($url, $options);

        $payload = $response->{$this->getFormat()}();
        $payload = json_decode(json_encode($payload), true);

        $listings = $this->getRawListings($payload);

        return $this->getJobsCollectionFromListings($listings);
    }
}
