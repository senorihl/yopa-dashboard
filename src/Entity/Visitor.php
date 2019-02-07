<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Visitor
 *
 * @ORM\Table(name="visitor")
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 */
class Visitor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="internal_id", type="string", nullable=true)
     */
    private $internalId;

    /**
     * @ORM\Column(name="client_id", type="json", nullable=true)
     */
    private $clientId;

    /**
     * @ORM\Column(name="client_group", type="json", nullable=true)
     */
    private $clientGroup;

    /**
     * @ORM\OneToMany(targetEntity="Visit", mappedBy="visitor")
     * @ORM\OrderBy(value={"occurredAt"="desc"})
     */
    private $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternalId(): ?string
    {
        return $this->internalId;
    }

    public function setInternalId(?string $internalId): self
    {
        $this->internalId = $internalId;

        return $this;
    }

    public function getClientId(): ?array
    {
        return $this->clientId;
    }

    public function setClientId(?array $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getClientGroup(): ?array
    {
        return $this->clientGroup;
    }

    public function setClientGroup(?array $clientGroup): self
    {
        $this->clientGroup = $clientGroup;

        return $this;
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits[] = $visit;
            $visit->setVisitor($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->contains($visit)) {
            $this->visits->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getVisitor() === $this) {
                $visit->setVisitor(null);
            }
        }

        return $this;
    }


}
