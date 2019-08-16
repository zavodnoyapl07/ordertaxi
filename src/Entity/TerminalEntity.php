<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="terminal", indexes={@ORM\Index(name="terminal_airport_id_index", columns={"airport_id"})})
 * @ORM\Entity
 */
class TerminalEntity
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
	 * @var AirportEntity
	 *
	 * @ORM\ManyToOne(targetEntity="AirportEntity", cascade={"persist"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="airport_id", referencedColumnName="id", nullable=false)
	 * })
	 */
	private $airport;

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
	 * @return AirportEntity
	 */
	public function getAirport(): AirportEntity
	{
		return $this->airport;
	}

	/**
	 * @param AirportEntity $airport
	 */
	public function setAirport(AirportEntity $airport): void
	{
		$this->airport = $airport;
	}
}