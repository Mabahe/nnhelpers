
.. include:: ../../Includes.txt

.. _Db:

==============================================
Db
==============================================

\\nn\\t3::Db()
----------------------------------------------

Zugriff auf die meist genutzten Datenbank-Operationen für Schreiben, Lesen, Löschen vereinfachen.

Overview of Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

\\nn\\t3::Db()->debug(``$query = NULL, $return = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Debug MySQL Query

.. code-block:: php

	\nn\t3::Db()->debug( $query );
	echo \nn\t3::Db()->debug( $query, true );

| ``@return string``

\\nn\\t3::Db()->delete(``$table = '', $constraint = [], $reallyDelete = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag löschen. Klein und Fein.

.. code-block:: php

	\nn\t3::Db()->delete('table', $uid);
	\nn\t3::Db()->delete('table', ['uid_local'=>$uid]);

| ``@return boolean``

\\nn\\t3::Db()->filterDataForTable(``$data = [], $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

In key/val-Array nur Elemente behalten, deren keys auch
in TCA für bestimmte Tabelle existieren
| ``@return array``

\\nn\\t3::Db()->findAll(``$table = '', $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

action findAll
Findet ALLE Eintrag

.. code-block:: php

	\nn\t3::Db()->findAll('fe_users');
	\nn\t3::Db()->findAll('fe_users', true);

| ``@return array``

\\nn\\t3::Db()->findByUid(``$table = '', $uid = NULL, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet einen Eintrag anhand der UID.
Funktioniert auch, wenn Frontend noch nicht initialisiert wurden,
z.B. während AuthentificationService läuft oder im Scheduler.

.. code-block:: php

	\nn\t3::Db()->findByUid('fe_user', 12);
	\nn\t3::Db()->findByUid('fe_user', 12, true);

| ``@param int $uid``
| ``@return array``

\\nn\\t3::Db()->findByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

action findByCustomField
Findet ALLE Einträge anhand eines gewünschten Feld-Wertes.
Funktioniert auch, wenn Frontend noch nicht initialisiert wurden,

.. code-block:: php

	\nn\t3::Db()->findByValues('fe_users', ['email'=>'david@99grad.de']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->findOneByValues(``$table = NULL, $whereArr = [], $useLogicalOr = false, $ignoreEnableFields = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Findet EINEN Eintrag anhand von gewünschten Feld-Werten.

.. code-block:: php

	\nn\t3::Db()->findOneByValues('fe_users', ['email'=>'david@99grad.de']);

| ``@param string $table``
| ``@param array $whereArr``
| ``@param boolean $useLogicalOr``
| ``@param boolean $ignoreEnableFields``
| ``@return array``

\\nn\\t3::Db()->getColumn(``$table = '', $colName = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine Tabellen-Spalte (TCA) für bestimmte Tabelle holen

.. code-block:: php

	\nn\t3::Db()->getColumn( 'tablename', 'fieldname' );

| ``@return array``

\\nn\\t3::Db()->getColumnLabel(``$column = '', $table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Lokalisiertes Label eines bestimmten TCA Feldes holen
| ``@return string``

\\nn\\t3::Db()->getColumns(``$table = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Alle Tabellen-Spalten (TCA) für bestimmte Tabelle holen

.. code-block:: php

	\nn\t3::Db()->getColumns( 'tablename' );

| ``@return array``

\\nn\\t3::Db()->getColumnsByType(``$table = '', $colType = '', $useSchemaManager = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Felder einer Tabelle nach einem bestimmten Typ holen

.. code-block:: php

	\nn\t3::Db()->getColumnsByType( 'tx_news_domain_model_news', 'slug' );

| ``@return array``

\\nn\\t3::Db()->getConnection();
"""""""""""""""""""""""""""""""""""""""""""""""

Eine "rohe" Verbindung zur Datenbank holen.
Nur in wirklichen Notfällen sinnvoll.

.. code-block:: php

	$connection = \nn\t3::Db()->getConnection();
	$connection->fetchAll( 'SELECT  FROM tt_news WHERE 1;' );

| ``@return \TYPO3\CMS\Core\Database\Connection``

\\nn\\t3::Db()->getDeleteColumn(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Delete-Column für bestimmte Tabelle holen.
Diese Spalte wird als Flag für gelöschte Datensätze verwendet.
Normalerweise: deleted = 1

| ``@return string``

\\nn\\t3::Db()->getQueryBuilder(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

QueryBuilder für eine Tabelle holen

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );

Beispiel:

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( 'fe_users' );
	$queryBuilder->select('name')->from( 'fe_users' );
	$queryBuilder->andWhere( $queryBuilder->expr()->eq( 'uid', $queryBuilder->createNamedParameter(12) ));
	$rows = $queryBuilder->execute()->fetchAll();

| ``@param string $table``
| ``@return QueryBuilder``

\\nn\\t3::Db()->getRepositoryForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Repository für ein Model holen.

.. code-block:: php

	\nn\t3::Db()->getRepositoryForModel( \My\Domain\Model\Name );

| ``@return string``

\\nn\\t3::Db()->getTableNameForModel(``$className = NULL``);
"""""""""""""""""""""""""""""""""""""""""""""""

Tabellen-Name für ein Model holen.
Alias zu ``\nn\t3::Obj()->getTableName()``

.. code-block:: php

	\nn\t3::Db()->getTableNameForModel( \My\Domain\Model\Name );

| ``@return string``

\\nn\\t3::Db()->ignoreEnableFields(``$queryOrRepository, $ignoreStoragePid = true, $ignoreHidden = false, $ignoreDeleted = false, $ignoreStartEnd = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Entfernt Default-Constraints zur StoragePID, hidden und/oder deleted
zu einer Query oder Repository.

.. code-block:: php

	\nn\t3::Db()->ignoreEnableFields( $entryRepository );
	\nn\t3::Db()->ignoreEnableFields( $query );

Beispiel für eine Custom Query:

.. code-block:: php

	$table = 'tx_myext_domain_model_entry';
	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	$queryBuilder->select('uid','title','hidden')->from( $table );
	\nn\t3::Db()->ignoreEnableFields( $queryBuilder, true, true );
	$rows = $queryBuilder->execute()->fetchAll();

Sollte das nicht reichen oder zu kompliziert werden, siehe:

.. code-block:: php

	\nn\t3::Db()->statement();

| ``@return boolean``

\\nn\\t3::Db()->insert(``$table = '', $data = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag einfügen. Simpel und idiotensicher.
Gibt Array der eingefügten Daten zurück inkl. insertUid des Eintrags

.. code-block:: php

	$insertArr = \nn\t3::Db()->insert('table', ['bodytext'=>'...']);

| ``@return int``

\\nn\\t3::Db()->orderBy(``$queryOrRepository, $ordering = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sortierung für ein Repository oder einen Query setzen.

.. code-block:: php

	$ordering = ['title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];
	\nn\t3::Db()->orderBy( $queryOrRepository, $ordering );

| ``@return $queryOrRepository``

\\nn\\t3::Db()->persistAll();
"""""""""""""""""""""""""""""""""""""""""""""""

Alles persistieren...

.. code-block:: php

	\nn\t3::Db()->persistAll();

| ``@return void``

\\nn\\t3::Db()->quote(``$str = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Ein Ersatz für die ``mysqli_real_escape_string()`` Methode.
Sollte nur im Notfall bei Low-Level Queries verwendet werden. Besser ist es,
preparedStatements zu verwenden.

Funktioniert nur bei SQL, nicht bei DQL.

.. code-block:: php

	$sword = \nn\t3::Db()->quote($sword);
	$sword = \nn\t3::Db()->quote('"; DROP TABLE fe_user;#');

| ``@return string``

\\nn\\t3::Db()->setFalConstraint(``$queryBuilder = NULL, $tableName = '', $falFieldName = '', $numFal = true, $operator = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constraint für sys_file_reference zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse darauf, ob es eine FAL-Relation gibt.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	
	// Nur Datensätze holen, die für falfield mindestes eine SysFileReference haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield' );
	
	// ... die KEINE SysFileReference für falfield haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', false );
	
	// ... die GENAU 2 SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2 );
	
	// ... die 2 oder weniger (less than or equal) SysFileReferences haben
	\nn\t3::Db()->setFalConstraint( $queryBuilder, 'tx_myext_tablename', 'falfield', 2, 'lte' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->setNotInSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories'``);
"""""""""""""""""""""""""""""""""""""""""""""""

Contraint auf Datensätze beschränken, die NICHT in eine der angegebenen Kategorien sind.
Gegenteil und Alias zu ``\nn\t3::Db()->setSysCategoryConstraint()``

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setNotInSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->setSysCategoryConstraint(``$queryBuilder = NULL, $sysCategoryUids = [], $tableName = '', $categoryFieldName = 'categories', $useNotIn = false``);
"""""""""""""""""""""""""""""""""""""""""""""""

Constraint für sys_category / sys_category_record_mm zu einem QueryBuilder hinzufügen.
Beschränkt die Ergebnisse auf die angegebenen Sys-Categories-UIDs.

.. code-block:: php

	$queryBuilder = \nn\t3::Db()->getQueryBuilder( $table );
	\nn\t3::Db()->setSysCategoryConstraint( $queryBuilder, [1,3,4], 'tx_myext_tablename', 'categories' );

| ``@return $queryBuilder``

\\nn\\t3::Db()->sortBy(``$objectArray, $fieldName = 'uid', $uidList = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Sortiert Ergebnisse eines Queries nach einem Array und bestimmten Feld.
Löst das Problem, dass eine ``->in()``-Query die Ergebnisse nicht
in der Reihenfolge der übergebenen IDs liefert. Beispiel:
| ``$query->matching($query->in('uid', [3,1,2]));`` kommt nicht zwingend
in der Reihenfolge ``[3,1,2]`` zurück.

.. code-block:: php

	$insertArr = \nn\t3::Db()->sortBy( $storageOrArray, 'uid', [2,1,5]);

| ``@return array``

\\nn\\t3::Db()->statement(``$statement = '', $params = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Eine "rohe" Query an die Datenbank absetzen.
Näher an der Datenbank geht nicht. Du bist für alles selbst verantwortlich.
Injections steht nur Deine (hoffentlich ausreichende :) Intelligenz entgegen.

Hilft z.B. bei Abfragen von Tabellen, die nicht Teil der Typo3 Installation sind und
daher über den normal QueryBuilder nicht erreicht werden könnten.

.. code-block:: php

	// Variablen IMMER über escapen!
	$keyword = \nn\t3::Db()->quote('suchbegriff');
	$rows = \nn\t3::Db()->statement( "SELECT  FROM tt_news WHERE bodytext LIKE '%${keyword}%'");
	
	// oder besser gleich prepared statements verwenden:
	$rows = \nn\t3::Db()->statement( 'SELECT  FROM tt_news WHERE bodytext LIKE :str', ['str'=>"%${keyword}%"] );

| ``@return mixed``

\\nn\\t3::Db()->tableExists(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Existiert eine bestimmte DB-Tabelle?

.. code-block:: php

	$exists = \nn\t3::Db()->tableExists('table');

| ``@return boolean``

\\nn\\t3::Db()->truncate(``$table = ''``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank leeren.

.. code-block:: php

	\nn\t3::Db()->truncate('table');

| ``@return boolean``

\\nn\\t3::Db()->undelete(``$table = '', $constraint = []``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag wiederherstellen.

\nn\t3::Db()->undelete('table', $uid);
\nn\t3::Db()->undelete('table', ['uid_local'=>$uid]);

| ``@return boolean``

\\nn\\t3::Db()->update(``$table, $data, $uid``);
"""""""""""""""""""""""""""""""""""""""""""""""

Datenbank-Eintrag aktualisieren. Schnell und einfach.

.. code-block:: php

	\nn\t3::Db()->update('table', [], 1);
	\nn\t3::Db()->update('table', [], ['email'=>'david@99grad.de', 'pid'=>12, ...]);

Mit ``true`` statt einer ``$uid`` werden ALLE Datensätze der Tabelle geupdated.

.. code-block:: php

	\nn\t3::Db()->update('table', ['test'=>1], true);

| ``@return boolean``
