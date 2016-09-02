<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Job;
use JobApis\Jobs\Client\Providers\CareerbuilderProvider;
use JobApis\Jobs\Client\Queries\CareerbuilderQuery;
use Mockery as m;

class CareerbuilderProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock('JobApis\Jobs\Client\Queries\CareerbuilderQuery');

        $this->client = new CareerbuilderProvider($this->query);
    }

    public function testItCanGetDefaultResponseFields()
    {
        $fields = [
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
        $this->assertEquals($fields, $this->client->getDefaultResponseFields());
    }

    public function testItCanGetListingsPath()
    {
        $this->assertEquals('Results.JobSearchResult', $this->client->getListingsPath());
    }

    public function testItCanGetResponseFormatXml()
    {
        $this->assertEquals('xml', $this->client->getFormat());
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
        $this->assertNull($result['min']);
        $this->assertNull($result['max']);
    }

    public function testItReturnsNullSalaryWhenInputIsOther()
    {
        $string = uniqid();
        $result = $this->client->parseSalariesFromString($string);
        $this->assertNull($result['min']);
        $this->assertNull($result['max']);
    }

    public function testItCanCreateJobObjectFromPayload()
    {
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    public function testItCanCreateJobFromPayloadWhenSingleSkillProvided()
    {
        $payload = $this->createJobArrayWithSingleSkill();
        $results = $this->client->createJobObject($payload);
        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    public function testItCanCreateJobFromPayloadWhenInvalidSkillProvided()
    {
        $payload = $this->createJobArrayWithInvalidSkill();
        $results = $this->client->createJobObject($payload);
        $this->assertEquals($payload['JobTitle'], $results->title);
        $this->assertEquals($payload['DescriptionTeaser'], $results->description);
        $this->assertEquals($payload['JobDetailsURL'], $results->url);
    }

    /**
     * Integration test for the client's getJobs() method.
     */
    public function testItCanGetJobs()
    {
        $options = [
            'Keywords' => uniqid(),
            'FacetCity' => uniqid(),
            'DeveloperKey' => uniqid(),
        ];

        $guzzle = m::mock('GuzzleHttp\Client');

        $query = new CareerbuilderQuery($options);

        $client = new CareerbuilderProvider($query);

        $client->setClient($guzzle);

        $response = m::mock('GuzzleHttp\Message\Response');

        $jobs = $this->getXmlJobs();

        $guzzle->shouldReceive('get')
            ->with($query->getUrl(), [])
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($jobs);

        $results = $client->getJobs();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertCount(3, $results);
    }

    /**
     * Integration test with actual API call to the provider.
     */
    public function testItCanGetJobsFromApi()
    {
        if (!getenv('DEVELOPER_KEY')) {
            $this->markTestSkipped('DEVELOPER_KEY not set. Real API call will not be made.');
        }

        $keyword = 'engineering';

        $query = new CareerbuilderQuery([
            'Keywords' => $keyword,
            'DeveloperKey' => getenv('DEVELOPER_KEY'),
        ]);

        $client = new CareerbuilderProvider($query);

        $results = $client->getJobs();

        $this->assertInstanceOf('JobApis\Jobs\Client\Collection', $results);

        foreach($results as $job) {
            $this->assertEquals($keyword, $job->query);
        }
    }

    private function createJobArray() {
        return [
            'Company' => uniqid(),
            'CompanyDetailsURL' => uniqid(),
            'DescriptionTeaser' => uniqid(),
            'DID' => uniqid(),
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
            'DID' => uniqid(),
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
            'DID' => uniqid(),
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

    private function getXmlJobs()
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
        <ResponseJobSearch>
            <Results>
                <JobSearchResult>
                    <Company>57c9f9c746716</Company>
                    <CompanyDetailsURL>57c9f9c746731</CompanyDetailsURL>
                    <DescriptionTeaser>57c9f9c746759</DescriptionTeaser>
                    <DID>57c9f9c746778</DID>
                    <OnetCode>57c9f9c746783</OnetCode>
                    <ONetFriendlyTitle>57c9f9c74679f</ONetFriendlyTitle>
                    <EmploymentType>57c9f9c7467aa</EmploymentType>
                    <EducationRequired>57c9f9c7467c6</EducationRequired>
                    <ExperienceRequired>57c9f9c7467d1</ExperienceRequired>
                    <JobDetailsURL>57c9f9c7467ed</JobDetailsURL>
                    <Location>57c9f9c7467f8</Location>
                    <City>57c9f9c746814</City>
                    <State>57c9f9c74681f</State>
                    <PostedDate>09/02/2016</PostedDate>
                    <Pay>57c9f9c746847</Pay>
                    <JobTitle>57c9f9c74684f</JobTitle>
                    <CompanyImageURL>57c9f9c74685a</CompanyImageURL>
                    <Skills>
                        <Skill>57c9f9c746862</Skill>
                        <Skill>57c9f9c74686d</Skill>
                        <Skill>57c9f9c746889</Skill>
                        <Skill>57c9f9c746894</Skill>
                    </Skills>
                </JobSearchResult>
                <JobSearchResult>
                    <Company>57c9f9c7468ce</Company>
                    <CompanyDetailsURL>57c9f9c7468e3</CompanyDetailsURL>
                    <DescriptionTeaser>57c9f9c7468f7</DescriptionTeaser>
                    <DID>57c9f9c746902</DID>
                    <OnetCode>57c9f9c74691e</OnetCode>
                    <ONetFriendlyTitle>57c9f9c746932</ONetFriendlyTitle>
                    <EmploymentType>57c9f9c74693d</EmploymentType>
                    <EducationRequired>57c9f9c746962</EducationRequired>
                    <ExperienceRequired>57c9f9c74696c</ExperienceRequired>
                    <JobDetailsURL>57c9f9c746974</JobDetailsURL>
                    <Location>57c9f9c74697c</Location>
                    <City>57c9f9c746985</City>
                    <State>57c9f9c74698d</State>
                    <PostedDate>09/02/2016</PostedDate>
                    <Pay>57c9f9c74699c</Pay>
                    <JobTitle>57c9f9c7469a5</JobTitle>
                    <CompanyImageURL>57c9f9c7469ad</CompanyImageURL>
                    <Skills>
                        <Skill>57c9f9c7469b5</Skill>
                        <Skill>57c9f9c7469bd</Skill>
                        <Skill>57c9f9c7469c5</Skill>
                        <Skill>57c9f9c7469ce</Skill>
                    </Skills>
                </JobSearchResult>
                <JobSearchResult>
                    <Company>57c9f9c7469f3</Company>
                    <CompanyDetailsURL>57c9f9c7469fb</CompanyDetailsURL>
                    <DescriptionTeaser>57c9f9c746a04</DescriptionTeaser>
                    <DID>57c9f9c746a0d</DID>
                    <OnetCode>57c9f9c746a15</OnetCode>
                    <ONetFriendlyTitle>57c9f9c746a1d</ONetFriendlyTitle>
                    <EmploymentType>57c9f9c746a25</EmploymentType>
                    <EducationRequired>57c9f9c746a2d</EducationRequired>
                    <ExperienceRequired>57c9f9c746a36</ExperienceRequired>
                    <JobDetailsURL>57c9f9c746a3e</JobDetailsURL>
                    <Location>57c9f9c746a46</Location>
                    <City>57c9f9c746a4e</City>
                    <State>57c9f9c746a56</State>
                    <PostedDate>09/02/2016</PostedDate>
                    <Pay>57c9f9c746a65</Pay>
                    <JobTitle>57c9f9c746a6d</JobTitle>
                    <CompanyImageURL>57c9f9c746a75</CompanyImageURL>
                    <Skills>
                        <Skill>57c9f9c746a7e</Skill>
                        <Skill>57c9f9c746a86</Skill>
                        <Skill>57c9f9c746a8f</Skill>
                        <Skill>57c9f9c746a97</Skill>
                    </Skills>
                </JobSearchResult>
            </Results>
        </ResponseJobSearch>";
    }
}
