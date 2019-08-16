<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Terminal;

/**
 * @ORM\Table(name="order_taxi", indexes={
 *     @ORM\Index(name="order_taxi_airport_id_index", columns={"airport_id"}),
 *     @ORM\Index(name="order_taxi_terminal_id_index", columns={"terminal_id"})
 * })
 * @ORM\Entity
 */
class OrderTaxiEntity
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
	 * @var AirportEntity
	 *
	 * @ORM\ManyToOne(targetEntity="AirportEntity", cascade={"persist"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="airport_id", referencedColumnName="id", nullable=false)
	 * })
	 */
	private $airport;

	/**
	 * @var AirportEntity
	 *
	 * @ORM\ManyToOne(targetEntity="TerminalEntity", cascade={"persist"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="terminal_id", referencedColumnName="id", nullable=true)
	 * })
	 */
	private $terminal;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="client_name", type="string", length=100, nullable=false)
	 */
	private $clientName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="phone", type="string", length=20, nullable=false)
	 */
	private $phone;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="airfligth_number", type="string", length=10, nullable=false)
	 */
	private $airflightNumber;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	public function __construct()
	{
		$this->createdAt = new \DateTime();
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
	 * @return AirportEntity|null
	 */
	public function getAirport(): ?AirportEntity
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

	/**
	 * @return TerminalEntity|null
	 */
	public function getTerminal(): ?TerminalEntity
	{
		return $this->terminal;
	}

	/**
	 * @param TerminalEntity $terminal
	 */
	public function setTerminal(TerminalEntity $terminal): void
	{
		$this->terminal = $terminal;
	}

	/**
	 * @return string|null
	 */
	public function getClientName(): ?string
	{
		return $this->clientName;
	}

	/**
	 * @param string $clientName
	 */
	public function setClientName(string $clientName): void
	{
		$this->clientName = $clientName;
	}

	/**
	 * @return string|null
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(string $phone): void
	{
		$this->phone = $phone;
	}

	/**
	 * @return string|null
	 */
	public function getAirflightNumber(): ?string
	{
		return $this->airflightNumber;
	}

	/**
	 * @param string $airflightNumber
	 */
	public function setAirflightNumber(string $airflightNumber): void
	{
		$this->airflightNumber = mb_strtoupper($airflightNumber);
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}
}