<?php
namespace Sellastica\Utils;

/**
 * DateTime tools library
 */
class DateTime extends \Nette\Utils\DateTime
{
	/**
	 * @param \DateTime $dateTime
	 * @param \Nette\Localization\ITranslator $translator
	 * @param bool $seconds
	 * @return string
	 */
	public static function prettify(
		\DateTime $dateTime,
		\Nette\Localization\ITranslator $translator,
		bool $seconds = false
	): string
	{
		$today = new \DateTime('today');
		$yesterday = new \DateTime('yesterday');
		$tomorrow = new \DateTime('tomorrow');
		$afterTomorrow = new \DateTime('tomorrow + 1 day');
		$format = $seconds ? 'G:i:s' : 'G:i';

		if ($dateTime >= $tomorrow && $dateTime < $afterTomorrow) {
			$string = $translator->translate('system.date_time.tommorow_at', ['time' => $dateTime->format($format)]);
		} elseif ($dateTime >= $today && $dateTime < $tomorrow) {
			$string = $translator->translate('system.date_time.today_at', ['time' => $dateTime->format($format)]);
		} elseif ($dateTime >= $yesterday && $dateTime < $tomorrow) {
			$string = $translator->translate('system.date_time.yesterday_at', ['time' => $dateTime->format($format)]);
		} else {
			$string = $dateTime->format($translator->translate($seconds ? 'j.n.Y G:i:s' : 'j.n.Y G:i'));
		}

		return $string;
	}

	/**
	 * Correct time range must have from date lower than till date, or some of them equal null
	 *
	 * @param \DateTime $from
	 * @param \DateTime $till
	 * @param bool $allowNullBoundaries
	 * @return bool
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function isRange(
		\DateTime $from = null,
		\DateTime $till = null,
		$allowNullBoundaries = true
	): bool
	{
		if ($allowNullBoundaries !== true) {
			if (is_null($from) || is_null($till)) {
				throw new \Nette\InvalidArgumentException('Date boundaries cannot be null.');
			}
		}

		if (is_null($from)) {
			$isRange = true;
		} elseif (is_null($till)) {
			$isRange = true;
		} else {
			$isRange = $from <= $till;
		}

		return $isRange;
	}

	/**
	 * Returns TRUE, if a DateTime is between from and till
	 *
	 * @param \DateTime $dateTime
	 * @param \DateTime $from
	 * @param \DateTime $till
	 * @param bool $allowNullBoundaries
	 * @return bool
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function isInRange(
		\DateTime $dateTime,
		\DateTime $from = null,
		\DateTime $till = null,
		$allowNullBoundaries = true
	): bool
	{
		if ($allowNullBoundaries !== true) {
			if (is_null($from) || is_null($till)) {
				throw new \Nette\InvalidArgumentException('Date boundaries cannot be null.');
			}
		}

		if (is_null($from)) {
			$inRange = is_null($till) || ($dateTime <= $till);
		} elseif (is_null($till)) {
			$inRange = is_null($from) || ($dateTime >= $from);
		} else {
			$inRange = ($dateTime >= $from) && ($dateTime <= $till);
		}

		return $inRange;
	}

	/**
	 * @param \DateTime $from1
	 * @param \DateTime $till1
	 * @param \DateTime $from2
	 * @param \DateTime $till2
	 * @return bool
	 */
	public static function areDateRangesCrossed(
		\DateTime $from1 = null,
		\DateTime $till1 = null,
		\DateTime $from2 = null,
		\DateTime $till2 = null
	): bool
	{
		$from1Timestamp = !is_null($from1) ? $from1->getTimestamp() : null;
		$till1Timestamp = !is_null($till1) ? $till1->getTimestamp() : null;
		$from2Timestamp = !is_null($from2) ? $from2->getTimestamp() : null;
		$till2Timestamp = !is_null($till2) ? $till2->getTimestamp() : null;

		return Numbers::areRangesCrossed($from1Timestamp, $till1Timestamp, $from2Timestamp, $till2Timestamp);
	}
}