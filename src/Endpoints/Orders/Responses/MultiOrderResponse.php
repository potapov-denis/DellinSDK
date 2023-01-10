<?php

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Orders\Responses;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\StatusChangeType;

final class MultiOrderResponse
{
	use DataAware;

	private int $requestID;
	private ?StatusChangeType $status = null;

	/**
	 * @return int
	 */
	public function getRequestID(): int
	{
		return $this->get('requestID');
	}

	/**
	 * @return StatusChangeType
	 */
	public function getStatus(): ?StatusChangeType
	{
		return StatusChangeType::TryFrom($this->get('status'));
	}


	public function toArray(): array
	{
		return $this->data;
	}
}