<?php

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Orders\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;

final class MultiOrderRequest implements Arrayable
{
	use DataAware, Login;

	private array $requestIds;
	private ?string $comment = null;

	/**
	 * Запрос метода Мультизаявка
	 *
	 * @see https://dev.dellin.ru/api/ordering/multi-request/#_header3
	 */
	public static function create(array $requestIds): MultiOrderRequest
	{
		return new MultiOrderRequest(...\func_get_args());
	}


	/**
	 * Запрос метода Мультизаявка
	 *
	 * @see https://dev.dellin.ru/api/ordering/multi-request/#_header3
	 */
	public function __construct(array $requestIds)
	{
		$this->setRequestIds($requestIds);
	}

	/**
	 * Получить перечень ID ранее созданных заказов, которые требуется объединить в мультизаявку
	 *
	 * @return array
	 */
	public function getRequestIds(): array
	{
		return $this->requestIds;
	}

	/**
	 * Установить перечень ID ранее созданных заказов, которые требуется объединить в мультизаявку
	 *
	 * @param array $requestIds
	 */
	public function setRequestIds(array $requestIds): void
	{
		$this->requestIds = $requestIds;
	}

	/**
	 * Получить комментарий к мультизаявке
	 *
	 * @return string|null
	 */
	public function getComment(): ?string
	{
		return $this->comment;
	}

	/**
	 * Установить комментарий к мультизаявке
	 *
	 * @param string|null $comment
	 */
	public function setComment(?string $comment): void
	{
		$this->comment = $comment;
	}


	public function toArray(): array
	{
		$this->data['requestids'] = $this->requestIds;
		if ($this->comment) $this->data['comment'] = $this->comment;
		return $this->data;
	}
}