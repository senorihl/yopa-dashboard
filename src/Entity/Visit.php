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

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getPreviousUrl(): ?string
    {
        return $this->previousUrl;
    }

    public function setPreviousUrl(?string $previousUrl): self
    {
        $this->previousUrl = $previousUrl;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(?string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getBrowser()
    {
        return get_browser($this->userAgent);
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(?string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getOccurredAt(): ?\DateTimeInterface
    {
        return $this->occurredAt;
    }

    public function setOccurredAt(\DateTimeInterface $occurredAt): self
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(?Visitor $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function getGeolocation(): ?GeoLocation
    {
        return $this->geolocation;
    }

    public function setGeolocation(?GeoLocation $geolocation): self
    {
        $this->geolocation = $geolocation;

        return $this;
    }
}
