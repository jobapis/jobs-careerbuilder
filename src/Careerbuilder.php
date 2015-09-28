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
    protected $companyCollapse;

    /**
     * Returns the standardized job object
     *
     * @param array $payload Raw job payload from the API
     *
     * @return \JobBrander\Jobs\Client\Job
     */
    public function createJobObject($payload = [])
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
            'PostedDate',
            'Pay',
            'JobTitle',
            'CompanyImageURL',
            'Skills',
        ];

        $payload = static::parseAttributeDefaults($payload, $defaults);

        $job = new Job(
            [
            'description' => $payload['DescriptionTeaser'],
            'employmentType' => $payload['EmploymentType'],
            'title' => $payload['JobTitle'],
            'name' => $payload['JobTitle'],
            'url' => $payload['JobDetailsURL'],
            'educationRequirements' => $payload['EducationRequired'],
            'experienceRequirements' => $payload['ExperienceRequired'],
            'sourceId' => $payload['DID'],
            ]
        );

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
            $job->setSkills($this->getSkillSet($payload['Skills']['Skill']));
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
    public function getCompanyCollapse()
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
        $queryParams = [
            'DeveloperKey' => 'getDeveloperKey',
            'Keywords' => 'getKeyword',
            'FacetState' => 'getState',
            'FacetCity' => 'getCity',
            'PageNumber' => 'getPage',
            'PerPage' => 'getCount',
            'UseFacets' => 'getUseFacets',
            'EnableCompanyCollapse' => 'getCompanyCollapse',
        ];

        $queryString = [];

        array_walk(
            $queryParams,
            function ($value, $key) use (&$queryString) {
                $computedValue = $this->$value();
                if (!is_null($computedValue)) {
                    $queryString[$key] = $computedValue;
                }
            }
        );

        return http_build_query($queryString);
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

    public function parseAnnualRange($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+k)\s.\s(.\d+k)/", function ($matches) use (&$salary) {
            $salary['min'] = str_replace('k', '000', $matches[1]);
            $salary['max'] = str_replace('k', '000', $matches[2]);
        }, $input);

        return $salary;
    }

    public function parseAnnualFixed($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+k)/", function ($matches) use (&$salary) {
            $salary['min'] = str_replace('k', '000', $matches[1]);
        }, $input);

        return $salary;
    }

    public function parseHourlyRange($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+.\d+)\s.\s(.\d+.\d+)/", function ($matches) use (&$salary) {
            $salary['min'] = $matches[1];
            $salary['max'] = $matches[2];
        }, $input);

        return $salary;
    }

    public function parseHourlyFixed($salary = [], $input = null)
    {
        preg_replace_callback("/(.\d+.\d+)/", function ($matches) use (&$salary) {
            $salary['min'] = $matches[1];
        }, $input);

        return $salary;
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

    public function getSkillSet($skills)
    {
        if (is_array($skills)) {
            return implode(', ', $skills);
        } elseif (is_string($skills)) {
            return $skills;
        }
        return null;
    }
}
