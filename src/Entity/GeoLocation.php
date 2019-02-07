<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoLocation
 *
 * @ORM\Table(name="geo_location")
 * @ORM\Entity(repositoryClass="App\Repository\GeoLocationRepository")
 */
class GeoLocation
{
    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", nullable=false)
     * @ORM\Id
     */
    private $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_code", type="string", nullable=true)
     */
    private $countryCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region", type="string", nullable=true)
     */
    private $region;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_code", type="string", nullable=true)
     */
    private $regionCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal", type="string", nullable=true)
     */
    private $postal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="timezone", type="string", nullable=true)
     */
    private $timezone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    public function setRegionCode(?string $regionCode): self
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(?string $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }


}
