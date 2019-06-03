<?php



/**
 * This class defines the structure of the 'author_key_value' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.bookstore.map
 */
class AuthorKVTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'bookstore.map.AuthorKVTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('author_key_value');
        $this->setPhpName('AuthorKV');
        $this->setClassname('AuthorKV');
        $this->setPackage('bookstore');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('AUTHOR_ID', 'AuthorId', 'INTEGER' , 'author', 'ID', true, null, null);
        $this->addColumn('KEY', 'Key', 'VARCHAR', true, 128, null);
        $this->addColumn('VALUE', 'Value', 'VARCHAR', true, 128, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Author', 'Author', RelationMap::MANY_TO_ONE, array('author_id' => 'id', ), null, null);
    } // buildRelations()

} // AuthorKVTableMap
