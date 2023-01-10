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

namespace Yooogi\DellinSDK\Endpoints\Services\Responses\Traits;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\PackageType;

trait PackagesTrait
{
	use DataAware;

	/**
	 * Информация об упаковках, доступных с учётом указанных условий перевозки
	 *
	 * @return PackageType[]|array
	 */
	public function getPackages(): array
	{
		return array_map(static function ($package) {
			return PackageType::PackageTryFrom($package['uid']);
		}, (array)$this->get('packages'));
	}

	/**
	 * Информация об упаковках, доступных с учётом указанных условий перевозки
	 * Включая несовместимые типы
	 *
	 * @return array
	 */
	public function getPackagesWithIncompatible(): array
	{
		return array_map(static function ($package) {
			return ['type' => PackageType::PackageTryFrom($package['uid']),
				'incompatible_uids' =>
					is_array($package['incompatible_uids']) ? array_filter(array_map(static function ($incompatible_uid) {
						return isset(PackageType::PACKAGES_AVAILABLE[$incompatible_uid]) ? PackageType::PackageTryFrom($incompatible_uid) : false;

					}, $package['incompatible_uids'])) : null

			];
		}, (array)$this->get('packages'));
	}

}