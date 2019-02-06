<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visit
 *
 * @ORM\Table(name="visit")
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="visit_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="text", nullable=false)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="full_action", type="text", nullable=false)
     */
    private $fullAction;

    /**
     * @var string
     *
     * @ORM\Column(name="breadcrumb", type="json_array", nullable=false)
     */
    private $breadcrumb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="previous_url", type="text", nullable=true)
     */
    private $previousUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="screen_size", type="string", nullable=true)
     */
    private $screenSize;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_agent", type="string", nullable=true)
     */
    private $userAgent;

    /**
     * @var string|null
     *
     * @ORM\Column(name="device", type="string", nullable=true)
     */
    private $device;

    /**
     * @var string|null
     *
     * @ORM\Column(name="language", type="string", nullable=true)
     */
    private $language;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="occurred_at", type="datetime", nullable=false, options={"default"="now()"})
     */
    private $occurredAt;

    /**
     * @var Visitor
     *
     * @ORM\ManyToOne(targetEntity="Visitor", inversedBy="visits", fetch="EAGER")
     * @ORM\JoinColumn(name="visitor_id", referencedColumnName="id")
     */
    private $visitor;

    /**
     * @var GeoLocation
     *
     * @ORM\ManyToOne(targetEntity="GeoLocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="geolocation_ip", referencedColumnName="ip")
     * })
     */
    private $geolocation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getPreviousUrl(): ?string
    {
        return $this->previousUrl;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function getBrowser()
    {
        return get_browser($this->userAgent);
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getOccurredAt(): ?\DateTimeInterface
    {
        return $this->occurredAt;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function getGeolocation(): ?GeoLocation
    {
        return $this->geolocation;
    }

    public function getFullAction(): ?string
    {
        return $this->fullAction;
    }

    public function getBreadcrumb(): ?string
    {
        return $this->breadcrumb;
    }
}
