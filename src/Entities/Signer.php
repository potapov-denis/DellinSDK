<?php

declare(strict_types=1);

namespace Yooogi\DellinSDK\Entities;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\EltcForwarderReqKindType;
use Yooogi\DellinSDK\Enum\SignerRole;

/**
 * Данные адресата электронного поручения экспедитору (ЭПЭ).
 *
 * Для получения черновика должен быть указан хотя бы один email или UID
 * личного кабинета оператора ЭДО.
 */
final class Signer implements Arrayable
{
	use DataAware;

	private SignerRole $role;

	/** @var string[] */
	private array $emails = [];

	private ?string $lkEdoUID = null;

	/* @var EltcForwarderReqKindType */
	private EltcForwarderReqKindType $eltcForwarderReqKindType = EltcForwarderReqKindType::DRAFT;

	/**
	 * @param string|string[]|null $emails Один или несколько адресов электронной почты
	 */
	public function __construct(SignerRole $role, string|array|null $emails = null, ?string $lkEdoUID = null)
	{
		$this->setRole($role);

		if (is_string($emails)) {
			$this->setEmail($emails);
		} elseif (is_array($emails)) {
			$this->setEmails($emails);
		}

		$this->setLkEdoUID($lkEdoUID);
	}

	/**
	 * @param string|string[]|null $emails Один или несколько адресов электронной почты
	 */
	public static function create(SignerRole $role, string|array|null $emails = null, ?string $lkEdoUID = null): self
	{
		return new self(...\func_get_args());
	}

	public function getRole(): SignerRole
	{
		return $this->role;
	}

	public function setRole(SignerRole $role): self
	{
		$this->role = $role;
		return $this;
	}

	/**
	 * Возвращает первый email, если он задан.
	 */
	public function getEmail(): ?string
	{
		return $this->emails[0] ?? null;
	}

	/**
	 * Задаёт единственный email для получения черновика ЭПЭ.
	 */
	public function setEmail(?string $email): self
	{
		$this->emails = $email !== null && $email !== '' ? [$email] : [];
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getEmails(): array
	{
		return $this->emails;
	}

	/**
	 * @param string[] $emails
	 */
	public function setEmails(array $emails): self
	{
		$this->emails = array_values($emails);
		return $this;
	}

	public function getLkEdoUID(): ?string
	{
		return $this->lkEdoUID;
	}

	public function setLkEdoUID(?string $lkEdoUID): self
	{
		$this->lkEdoUID = $lkEdoUID;
		return $this;
	}

	public function getEltcForwarderReqKindType(): EltcForwarderReqKindType
	{
		return $this->eltcForwarderReqKindType;
	}

	public function setEltcForwarderReqKindType(EltcForwarderReqKindType $eltcForwarderReqKindType): void
	{
		$this->eltcForwarderReqKindType = $eltcForwarderReqKindType;
	}



	public function toArray(): array
	{
		$this->data = ['role' => $this->role->value];

		if ($this->emails !== []) {
			$this->data['emails'] = $this->emails;
		}

		if ($this->lkEdoUID !== null && $this->lkEdoUID !== '') {
			$this->data['lkEdoUID'] = $this->lkEdoUID;
		}

		if ($this->eltcForwarderReqKindType !== null ) {
			$this->data['eltcForwarderReqKindType'] = $this->eltcForwarderReqKindType->value;
		}


		return $this->data;
	}
}
