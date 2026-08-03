<?php

declare(strict_types=1);

namespace Yooogi\DellinSDK\Enum;

/**
 * Роль адресата электронного поручения экспедитору (ЭПЭ).
 */
enum SignerRole: string
{
	case SENDER = 'sender';
	case RECEIVER = 'receiver';
	case PAYER = 'payer';
}
