<?php namespace JobBrander\Jobs\Client\Providers\Test;

use JobBrander\Jobs\Client\Providers\Dice;
use Mockery as m;

class DiceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new Dice();
    }

    public function testItWillUseJsonFormat()
    {
        $format = $this->client->getFormat();

        $this->assertEquals('json', $format);
    }

    public function testItWillUseGetHttpVerb()
    {
        $verb = $this->client->getVerb();

        $this->assertEquals('GET', $verb);
    }

    public function testListingPath()
    {
        $path = $this->client->getListingsPath();

        $this->assertEquals('resultItemList', $path);
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
        $param = 'text='.urlencode($keyword);

        $url = $this->client->setKeyword($keyword)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesKeywordWhenNotProvided()
    {
        $param = 'text=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCityWhenCityProvided()
    {
        $city = uniqid();
        $param = 'city='.urlencode($city);

        $url = $this->client->setCity($city)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlIncludesStateWhenStateProvided()
    {
        $state = uniqid();
        $param = 'state='.urlencode($state);

        $url = $this->client->setState($state)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesCityWhenNotProvided()
    {
        $param = 'city=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlNotIncludesStateWhenNotProvided()
    {
        $param = 'state=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesPageWhenProvided()
    {
        $page = uniqid();
        $param = 'page='.$page;

        $url = $this->client->setPage($page)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesPageWhenNotProvided()
    {
        $param = 'page=';

        $url = $this->client->setPage(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCountWhenProvided()
    {
        $count = uniqid();
        $param = 'pgcnt='.$count;

        $url = $this->client->setCount($count)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesStartWhenNotProvided()
    {
        $param = 'pgcnt=';

        $url = $this->client->setCount(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testItCanConnect()
    {
        $job_count = rand(2,10);
        $listings = ['resultItemList' => $this->createJobArray($job_count)];
        $source = $this->client->getSource();
        $keyword = 'project manager';

        $this->client->setKeyword($keyword)
            ->setCity('Chicago')
            ->setState('IL');

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive($this->client->getFormat())->once()->andReturn($listings);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($this->client->getVerb()))
            ->with($this->client->getUrl(), $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        foreach ($listings['resultItemList'] as $i => $result) {
            $this->assertEquals($listings['resultItemList'][$i]['jobTitle'], $results->get($i)->title);
            $this->assertEquals($listings['resultItemList'][$i]['company'], $results->get($i)->company);
            $this->assertEquals($listings['resultItemList'][$i]['location'], $results->get($i)->location);
            $this->assertEquals($listings['resultItemList'][$i]['detailUrl'], $results->get($i)->url);
            $this->assertEquals($keyword, $results->get($i)->query);
            $this->assertEquals($source, $results->get($i)->source);
        }

        $this->assertEquals(count($listings['resultItemList']), $results->count());

    }

    private function createJobArray($num = 10) {
        $jobs = [];
        $i = 0;
        while ($i < 10) {
            $jobs[] = [
                'jobTitle' => uniqid(),
                'company' => uniqid(),
                'location' => uniqid(),
                'date' => uniqid(),
                'detailUrl' => uniqid(),
            ];
            $i++;
        }
        return $jobs;
    }
}
