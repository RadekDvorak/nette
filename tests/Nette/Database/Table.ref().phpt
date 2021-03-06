<?php

/**
 * Test: Nette\Database\Table: Reference ref().
 *
 * @author     Jan Skrasek
 * @package    Nette\Database
 * @dataProvider? databases.ini
 */

require __DIR__ . '/connect.inc.php'; // create $connection

Nette\Database\Helpers::loadFromFile($connection, __DIR__ . "/{$driverName}-nette_test1.sql");



Assert::same('Jakub Vrana', $connection->table('book')->get(1)->ref('author')->name);



$book = $connection->table('book')->get(1);
$book->update(array(
	'translator_id' => 12,
));



$book = $connection->table('book')->get(1);
Assert::same('David Grudl', $book->ref('author', 'translator_id')->name);
Assert::same('Jakub Vrana', $book->ref('author', 'author_id')->name);



Assert::null($connection->table('book')->get(2)->ref('author', 'translator_id'));
