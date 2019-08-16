<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="airport")
 * @ORM\Entity
 */
class AirportEntity
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="terminal_id_seq", allocationSize=1, initialValue=1)
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=10, nullable=false)
	 */
	private $name;

	/**
	 * @var TerminalEntity[]|ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="TerminalEntity", mappedBy="airport", cascade={"persist"})
	 */
	private $terminals;

	public function __construct()
	{
		$this->terminals = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return TerminalEntity[]|ArrayCollection
	 */
	public function getTerminals()
	{
		return $this->terminals;
	}

	/**
	 * @param TerminalEntity[]|ArrayCollection $terminals
	 */
	public function setTerminals($terminals): void
	{
		$this->terminals = $terminals;
	}

}