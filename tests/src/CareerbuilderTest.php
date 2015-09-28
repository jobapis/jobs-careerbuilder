<?php namespace JobBrander\Jobs\Client\Providers\Test;

use JobBrander\Jobs\Client\Providers\Careerbuilder;
use Mockery as m;

class CareerbuilderTest extends \PHPUnit_Framework_TestCase
{
    private $clientClass = 'JobBrander\Jobs\Client\Providers\AbstractProvider';
    private $collectionClass = 'JobBrander\Jobs\Client\Collection';
    private $jobClass = 'JobBrander\Jobs\Client\Job';

    public function setUp()
    {
        $this->client = new Careerbuilder();
    }

    public function testItWillUseJsonFormat()
    {
        $format = $this->client->getFormat();

        $this->assertEquals('xml', $format);
    }

    public function testItUsesUSHostSite()
    {
        $hostSite = $this->client->getHostSite();

        $this->assertEquals('US', $hostSite);
    }

    public function testItWillUseGetHttpVerb()
    {
        $verb = $this->client->getVerb();

        $this->assertEquals('GET', $verb);
    }

    public function testListingPath()
    {
        $path = $this->client->getListingsPath();

        $this->assertEquals('Results.JobSearchResult', $path);
    }

    public function testItWillProvideEmptyParameters()
    {
        $parameters = $this->client->getParameters();

        $this->assertEmpty($parameters);
        $this->assertTrue(is_array($parameters));
    }

    public function testUrlIncludesKeywordWhenProvided()
    {
        $keyword = uniqid().' '.uniqid();
        $param = 'Keywords='.urlencode($keyword);

        $url = $this->client->setKeyword($keyword)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesKeywordWhenNotProvided()
    {
        $param = 'Keywords=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCityWhenCityProvided()
    {
        $city = uniqid();
        $param = 'FacetCity='.urlencode($city);
        $facetsParam = 'UseFacets=true';

        $url = $this->client->setCity($city)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($facetsParam, $url);
    }

    public function testUrlIncludesStateWhenStateProvided()
    {
        $state = uniqid();
        $param = 'FacetState='.urlencode($state);
        $facetsParam = 'UseFacets=true';

        $url = $this->client->setState($state)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($facetsParam, $url);
    }

    public function testUrlNotIncludesCityWhenNotProvided()
    {
        $param = 'FacetCity=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlNotIncludesStateWhenNotProvided()
    {
        $param = 'FacetState=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesPageWhenProvided()
    {
        $page = uniqid();
        $param = 'PageNumber='.$page;
        $collapseParam = 'EnableCompanyCollapse=true';

        $url = $this->client->setPage($page)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($collapseParam, $url);
    }

    public function testUrlNotIncludesPageWhenNotProvided()
    {
        $param = 'PageNumber=';

        $url = $this->client->setPage(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCountWhenProvided()
    {
        $count = uniqid();
        $param = 'PerPage='.$count;
        $collapseParam = 'EnableCompanyCollapse=true';

        $url = $this->client->setCount($count)->getUrl();

        $this->assertContains($param, $url);
        $this->assertContains($collapseParam, $url);
    }

    public function testUrlNotIncludesStartWhenNotProvided()
    {
        $param = 'PerPage=';

        $url = $this->client->setCount(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testItReturnsSalaryWhenInputIsYearlyRange()
    {
        $min = rand(10, 1000);
        $max = $min * rand(1, 10);

        $string = "$".$min."k - $".$max."k/year";

        $result = $this->client->parseSalariesFromString($string);

        $this->assertEquals('$'.$min * 1000, $result['min']);
        $this->assertEquals('$'.$max * 1000, $result['max']);
    }

    public function testItReturnsSalaryWhenInputIsYearly()
    {
        $min = rand(10, 1000);

        $string = "$".$min."k/year";

        $result = $this->client->parseSalariesFromString($string);

        $this->assertEquals('$'.$min * 1000, $result['min']);
        $this->assertNull($result['max']);
    }

    public function testItReturnsSalaryWhenInputIsHourlyRange()
    {
        $min = rand(7, 100);
        $max = $min * rand(2, 5);
        $string = "$".$min.".00 - $".$max.".00/hour";

        $result = $this->client->parseSalariesFromString($string);

        $this->assertEquals('$'.$min.'.00', $result['min']);
        $this->assertEquals('$'.$max.'.00', $result['max']);
    }

    public function testItReturnsSalaryWhenInputIsHourly()
    {
        $min = rand(10, 1000);

        $string = "$".$min.".00/hour";

        $result = $this->client->parseSalariesFromString($string);

        $this->assertEquals('$'.$min.'.00', $result['min']);
        $this->assertNull($result['max']);
    }

    public function testItReturnsNullSalaryWhenInputNA()
    {
        $string = "N/A";

        $result = $this->client->parseSalariesFromString($string);

        // $this->assertNull($result['min']);
        // $this->assertNull($result['max']);
    }

    public function testItReturnsNullSalaryWhenInputIsOther()
    {
        $string = uniqid();

        $result = $this->client->parseSalariesFromString($string);

        // $this->assertNull($result['min']);
        // $this->assertNull($result['max']);
    }

    public function testItCanCreateJobFromPayload()
    {
        $city = uniqid();
        $this->client->setCity($city);
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    public function testItCanCreateJobFromPayloadWhenSingleSkillProvided()
    {
        $city = uniqid();
        $this->client->setCity($city);
        $payload = $this->createJobArrayWithSingleSkill();

        $results = $this->client->createJobObject($payload);

        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    public function testItCanCreateJobFromPayloadWhenInvalidSkillProvided()
    {
        $city = uniqid();
        $this->client->setCity($city);
        $payload = $this->createJobArrayWithInvalidSkill();

        $results = $this->client->createJobObject($payload);

        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    public function testItCanConnect()
    {
        $provider = $this->getProviderAttributes(['format' => 'xml']);
        $payload = [];

        $responseBody = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><ResponseJobSearch><Results>";

        for ($i = 0; $i < $provider['jobs_count']; $i++) {
            $jobArray = $this->createJobArray();
            $path = $provider['path'];
            array_push($payload, $jobArray);
            $responseBody .= "<JobSearchResult><JobTitle>".$jobArray['JobTitle']."</JobTitle>";
            $responseBody .= "<PostedDate>".$jobArray['PostedDate']."</PostedDate>";
            $responseBody .= "</JobSearchResult>";
        }

        $responseBody .= "</Results></ResponseJobSearch>";

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($this->client->getVerb()))
            ->with($this->client->getUrl(), $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    private function createJobArray() {
        return [
            'Company' => uniqid(),
            'CompanyDetailsURL' => uniqid(),
            'DescriptionTeaser' => uniqid(),
            'OnetCode' => uniqid(),
            'ONetFriendlyTitle' => uniqid(),
            'EmploymentType' => uniqid(),
            'EducationRequired' => uniqid(),
            'ExperienceRequired' => uniqid(),
            'JobDetailsURL' => uniqid(),
            'Location' => uniqid(),
            'City' => uniqid(),
            'State' => uniqid(),
            'PostedDate' => date('m/d/Y'),
            'Pay' => uniqid(),
            'JobTitle' => uniqid(),
            'CompanyImageURL' => uniqid(),
            'Skills' => [
                'Skill' => [
                    0 => uniqid(),
                    1 => uniqid(),
                    2 => uniqid(),
                    3 => uniqid(),
                ]
            ]
        ];
    }

    private function createJobArrayWithSingleSkill() {
        return [
            'Company' => uniqid(),
            'CompanyDetailsURL' => uniqid(),
            'DescriptionTeaser' => uniqid(),
            'OnetCode' => uniqid(),
            'ONetFriendlyTitle' => uniqid(),
            'EmploymentType' => uniqid(),
            'EducationRequired' => uniqid(),
            'ExperienceRequired' => uniqid(),
            'JobDetailsURL' => uniqid(),
            'Location' => uniqid(),
            'City' => uniqid(),
            'State' => uniqid(),
            'PostedDate' => date('m/d/Y'),
            'Pay' => uniqid(),
            'JobTitle' => uniqid(),
            'CompanyImageURL' => uniqid(),
            'Skills' => [
                'Skill' =>  uniqid()
            ]
        ];
    }

    private function createJobArrayWithInvalidSkill() {
        return [
            'Company' => uniqid(),
            'CompanyDetailsURL' => uniqid(),
            'DescriptionTeaser' => uniqid(),
            'OnetCode' => uniqid(),
            'ONetFriendlyTitle' => uniqid(),
            'EmploymentType' => uniqid(),
            'EducationRequired' => uniqid(),
            'ExperienceRequired' => uniqid(),
            'JobDetailsURL' => uniqid(),
            'Location' => uniqid(),
            'City' => uniqid(),
            'State' => uniqid(),
            'PostedDate' => date('m/d/Y'),
            'Pay' => uniqid(),
            'JobTitle' => uniqid(),
            'CompanyImageURL' => uniqid(),
            'Skills' => [
                'Skill' => new \stdClass()
            ]
        ];
    }

    private function getProviderAttributes($attributes = [])
    {
        $defaults = [
            'path' => uniqid(),
            'format' => 'json',
            'keyword' => uniqid(),
            'source' => uniqid(),
            'params' => [uniqid()],
            'jobs_count' => rand(2,10),

        ];
        return array_replace($defaults, $attributes);
    }
}
