--TEST--
PDO Common: Bug #39398 (Booleans are not automatically translated to integers)
--SKIPIF--
<?php
if (!extension_loaded('pdo')) die('skip');
$dir = getenv('REDIR_TEST_DIR');
if (false == $dir) die('skip no driver');
require_once $dir . 'pdo_test.inc';
PDOTest::skip();
?>
--FILE--
<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/');
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';

$db = PDOTest::factory();
$db->exec("CREATE TABLE test (test INT)");

$boolean = 1;
$stmt = $db->prepare('INSERT INTO test VALUES (:boolean)');
$stmt->bindValue(':boolean', isset($boolean), PDO::PARAM_INT);
$stmt->execute();

var_dump($db->query("SELECT * FROM test")->fetchAll(PDO::FETCH_ASSOC));
?>
===DONE===
--EXPECT--
array(1) {
  [0]=>
  array(1) {
    ["test"]=>
    string(1) "1"
  }
}
===DONE===
