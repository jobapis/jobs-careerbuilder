<?php namespace JobApis\Jobs\Client\Queries;

class CareerbuilderQuery extends AbstractQuery
{
    /**
     * DeveloperKey
     *
     * @var string
     */
    protected $DeveloperKey;

    /**
     * AdvancedGroupingMode
     *
     * @var string
     */
    protected $AdvancedGroupingMode;

    /**
     * ApplyRequirements
     *
     * @var string
     */
    protected $ApplyRequirements;

    /**
     * BooleanOperator
     *
     * @var string
     */
    protected $BooleanOperator;

    /**
     * Category
     *
     * @var string
     */
    protected $Category;

    /**
     * CoBrand
     *
     * @var string
     */
    protected $CoBrand;

    /**
     * CompanyDID
     *
     * @var string
     */
    protected $CompanyDID;

    /**
     * CompanyDIDCSV
     *
     * @var string
     */
    protected $CompanyDIDCSV;

    /**
     * CompanyName
     *
     * @var string
     */
    protected $CompanyName;

    /**
     * CompanyNameBoostParams
     *
     * @var string
     */
    protected $CompanyNameBoostParams;

    /**
     * CountryCode
     *
     * @var string
     */
    protected $CountryCode;

    /**
     * EducationCode
     *
     * @var string
     */
    protected $EducationCode;

    /**
     * EmpType
     *
     * @var string
     */
    protected $EmpType;

    /**
     * EnableCompanyCollapse
     *
     * @var string
     */
    protected $EnableCompanyCollapse;

    /**
     * EnableCompanyJobTitleCollapse
     *
     * @var string
     */
    protected $EnableCompanyJobTitleCollapse;

    /**
     * ExcludeApplyRequirements
     *
     * @var string
     */
    protected $ExcludeApplyRequirements;

    /**
     * ExcludeCompanyNames
     *
     * @var string
     */
    protected $ExcludeCompanyNames;

    /**
     * ExcludeJobTitles
     *
     * @var string
     */
    protected $ExcludeJobTitles;

    /**
     * ExcludeKeywords
     *
     * @var string
     */
    protected $ExcludeKeywords;

    /**
     * ExcludeNational
     *
     * @var string
     */
    protected $ExcludeNational;

    /**
     * ExcludeNonTraditionalJobs
     *
     * @var string
     */
    protected $ExcludeNonTraditionalJobs;

    /**
     * FacetCategory
     *
     * @var string
     */
    protected $FacetCategory;

    /**
     * FacetCompany
     *
     * @var string
     */
    protected $FacetCompany;

    /**
     * FacetCity
     *
     * @var string
     */
    protected $FacetCity;

    /**
     * FacetState
     *
     * @var string
     */
    protected $FacetState;

    /**
     * FacetCityState
     *
     * @var string
     */
    protected $FacetCityState;

    /**
     * FacetPay
     *
     * @var string
     */
    protected $FacetPay;

    /**
     * FacetRelatedJobTitle
     *
     * @var string
     */
    protected $FacetRelatedJobTitle;

    /**
     * FacetCountry
     *
     * @var string
     */
    protected $FacetCountry;

    /**
     * FacetEmploymentType
     *
     * @var string
     */
    protected $FacetEmploymentType;

    /**
     * HostSite
     *
     * @var string
     */
    protected $HostSite;

    /**
     * IncludeCompanyChildren
     *
     * @var string
     */
    protected $IncludeCompanyChildren;

    /**
     * IndustryCodes
     *
     * @var string
     */
    protected $IndustryCodes;

    /**
     * JobTitle
     *
     * @var string
     */
    protected $JobTitle;

    /**
     * Keywords
     *
     * @var string
     */
    protected $Keywords;

    /**
     * Location
     *
     * @var string
     */
    protected $Location;

    /**
     * NormalizedCompanyDID
     *
     * @var string
     */
    protected $NormalizedCompanyDID;

    /**
     * NormalizedCompanyDIDBoostParams
     *
     * @var string
     */
    protected $NormalizedCompanyDIDBoostParams;

    /**
     * NormalizedCompanyName
     *
     * @var string
     */
    protected $NormalizedCompanyName;

    /**
     * ONetCode
     *
     * @var string
     */
    protected $ONetCode;

    /**
     * OrderBy
     *
     * @var string
     */
    protected $OrderBy;

    /**
     * OrderDirection
     *
     * @var string
     */
    protected $OrderDirection;

    /**
     * PageNumber
     *
     * @var string
     */
    protected $PageNumber;

    /**
     * PartnerID
     *
     * @var string
     */
    protected $PartnerID;

    /**
     * PayHigh
     *
     * @var string
     */
    protected $PayHigh;

    /**
     * PayInfoOnly
     *
     * @var string
     */
    protected $PayInfoOnly;

    /**
     * PayLow
     *
     * @var string
     */
    protected $PayLow;

    /**
     * PerPage
     *
     * @var string
     */
    protected $PerPage;

    /**
     * PostedWithin
     *
     * @var string
     */
    protected $PostedWithin;

    /**
     * Radius
     *
     * @var string
     */
    protected $Radius;

    /**
     * RecordsPerGroup
     *
     * @var string
     */
    protected $RecordsPerGroup;

    /**
     * RelocateJobs
     *
     * @var string
     */
    protected $RelocateJobs;

    /**
     * SOCCode
     *
     * @var string
     */
    protected $SOCCode;

    /**
     * SchoolSiteID
     *
     * @var string
     */
    protected $SchoolSiteID;

    /**
     * SearchAllCountries
     *
     * @var string
     */
    protected $SearchAllCountries;

    /**
     * SearchView
     *
     * @var string
     */
    protected $SearchView;

    /**
     * ShowCategories
     *
     * @var string
     */
    protected $ShowCategories;

    /**
     * ShowApplyRequirements
     *
     * @var string
     */
    protected $ShowApplyRequirements;

    /**
     * SingleONetSearch
     *
     * @var string
     */
    protected $SingleONetSearch;

    /**
     * SiteEntity
     *
     * @var string
     */
    protected $SiteEntity;

    /**
     * SiteID
     *
     * @var string
     */
    protected $SiteID;

    /**
     * Skills
     *
     * @var string
     */
    protected $Skills;

    /**
     * SpecificEducation
     *
     * @var string
     */
    protected $SpecificEducation;

    /**
     * SpokenLanguage
     *
     * @var string
     */
    protected $SpokenLanguage;

    /**
     * Tags
     *
     * @var string
     */
    protected $Tags;

    /**
     * TalentNetworkDID
     *
     * @var string
     */
    protected $TalentNetworkDID;

    /**
     * UrlCompressionService
     *
     * @var string
     */
    protected $UrlCompressionService;

    /**
     * UseFacets
     *
     * @var string
     */
    protected $UseFacets;

    /**
     * Get baseUrl
     *
     * @return  string Value of the base url to this api
     */
    public function getBaseUrl()
    {
        return 'http://api.careerbuilder.com/v2/jobsearch';
    }

    /**
     * Get keyword
     *
     * @return  string Attribute being used as the search keyword
     */
    public function getKeyword()
    {
        return $this->Keywords;
    }

    /**
     * Default parameters
     *
     * @var array
     */
    protected function defaultAttributes()
    {
        return [
            'EnableCompanyCollapse' => 'true',
            'HostSite' => 'US',
            'UseFacets' => 'true',
        ];
    }

    /**
     * Required parameters
     *
     * @return array
     */
    protected function requiredAttributes()
    {
        return [
            'DeveloperKey',
        ];
    }
}
