<?php
/*
 * *
 *  * This code is licensed under the MIT License.
 *  *
 *  * Copyright (c) 2022 Denis Potapov (https://yooogi.ru)
 *  *
 *  * Permission is hereby granted, free of charge, to any person obtaining a copy
 *  * of this software and associated documentation files (the "Software"), to deal
 *  * in the Software without restriction, including without limitation the rights
 *  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  * copies of the Software, and to permit persons to whom the Software is
 *  * furnished to do so, subject to the following conditions:
 *  *
 *  * The above copyright notice and this permission notice shall be included in
 *  * all copies or substantial portions of the Software.
 *  *
 *  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  * THE SOFTWARE.
 *
 */

declare(strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Authorization;

use Yooogi\DellinSDK\Endpoints\Authorization\Exceptions\AuthException;
use Yooogi\DellinSDK\Endpoints\Authorization\Exceptions\SessionInfoException;
use Yooogi\DellinSDK\Endpoints\Authorization\Requests\AuthRequest;
use Yooogi\DellinSDK\Endpoints\Authorization\Requests\SessionInfoRequest;
use Yooogi\DellinSDK\Endpoints\Authorization\Responses\AuthResponse;
use Yooogi\DellinSDK\Endpoints\Authorization\Responses\SessionInfoResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class Authorization
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Авторизация
	 *
	 * @param AuthRequest $request
	 *
	 * @return AuthResponse
	 * @throws @AuthException
	 *
	 * @link https://dev.dellin.ru/api/auth/login/
	 */
	public function auth(AuthRequest $request): AuthResponse
	{
		try {
			return $this->client->post('/v3/auth/login.json', $request, AuthResponse::class);
		} catch (BadRequest $e) {
			throw new AuthException($e);
		}
	}

	/**
	 * Информация по сессии
	 *
	 * @param SessionInfoRequest $request
	 *
	 * @return SessionInfoResponse
	 * @throws SessionInfoException
	 *
	 * @see https://dev.dellin.ru/api/auth/login/
	 *
	 */
	public function info(SessionInfoRequest $request): SessionInfoResponse
	{
		try {
			return $this->client->post('/v3/auth/session_info.json', $request, SessionInfoResponse::class);
		} catch (BadRequest $e) {
			throw new SessionInfoException($e);
		}
	}
}
