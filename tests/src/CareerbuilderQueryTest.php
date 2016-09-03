<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Queries\CareerbuilderQuery;
use Mockery as m;

class CareerbuilderQueryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = new CareerbuilderQuery();
    }

    public function testItAddsDefaultAttributes()
    {
        $this->assertEquals('true', $this->query->get('EnableCompanyCollapse'));
        $this->assertEquals('US', $this->query->get('HostSite'));
        $this->assertEquals('true', $this->query->get('UseFacets'));
    }

    public function testItCanGetBaseUrl()
    {
        $this->assertEquals(
            'http://api.careerbuilder.com/v1/jobsearch',
            $this->query->getBaseUrl()
        );
    }

    public function testItCanGetKeyword()
    {
        $keyword = uniqid();
        $this->query->set('Keywords', $keyword);
        $this->assertEquals($keyword, $this->query->getKeyword());
    }

    public function testItReturnsFalseIfRequiredAttributesMissing()
    {
        $this->assertFalse($this->query->isValid());
    }

    public function testItReturnsTrueIfRequiredAttributesPresent()
    {
        $this->query->set('DeveloperKey', uniqid());

        $this->assertTrue($this->query->isValid());
    }

    public function testItCanAddAttributesToUrl()
    {
        $url = $this->query->getUrl();
        $this->assertContains('EnableCompanyCollapse=', $url);
        $this->assertContains('UseFacets=', $url);
        $this->assertContains('HostSite=', $url);
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItThrowsExceptionWhenSettingInvalidAttribute()
    {
        $this->query->set(uniqid(), uniqid());
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItThrowsExceptionWhenGettingInvalidAttribute()
    {
        $this->query->get(uniqid());
    }

    public function testItSetsAndGetsValidAttributes()
    {
        $attributes = [
            'Keywords' => uniqid(),
            'Category' => uniqid(),
            'CountryCode' => uniqid(),
            'ExcludeJobTitles' => uniqid(),
        ];

        foreach ($attributes as $key => $value) {
            $this->query->set($key, $value);
        }

        foreach ($attributes as $key => $value) {
            $this->assertEquals($value, $this->query->get($key));
        }
    }
}
