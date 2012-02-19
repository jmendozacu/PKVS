<?php
/**
 * The Models that controll the CMS Page adding process
 *
 * By using this model we can CRUD CMS pages.
 *
 * @author Jānis Peisenieks
 * @package CMS
 * @subpackage Admin
 */
/**
 * The Models that controll the CMS Page adding process
 *
 * By using this model we can CRUD CMS pages.
 *
 * @author Jānis Peisenieks
 * @package CMS
 * @subpackage Admin
 */

class Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    protected $_rowClass="Model_User_Row";



    public function createDraugiemUser($data)
    {
        $row = $this->createRow();
         

        // set the row data
        $row->name = $data['name']." ".$data['surname'];
        $row->role = 'user';
        $row->email = "sdf";
        $row->icon= $data['img'];

        $row->draugiemId = $data['uid'];
        $row->registered = date('Y-m-d H:i:s');

        // save the new row
        $row->save();

        // now fetch the id of the row you just created and return it
        $id = $this->_db->lastInsertId();
        return $id;
    }

    public function processUserFromDraugiem($data, &$register = false)
    {


        if (NULL != $row = $this->getDraugiemUser($data['uid'])) {
            return $row;
        }
        else {
            $register = true;
            $this->createDraugiemUser($data);
            return $this->getDraugiemUser($data['uid']);
        }

    }

    public function getDraugiemUser($id)
    {
        $select = $this->select()->where('draugiemId=?', $id);
        $row = $this->fetchRow($select);
        return $row;
    }

    public function getUser($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('userId = ' . $id)->toArray();
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUserByUsername($username)
    {
        return $this->fetchRow($this->select()->from('users')->where('username=?', $username));
    }

    public function updateUser($id, $data)
    {
        $data['password'] = md5($data['password']);
        $where = $this->getAdapter()->quoteInto('userId=?', $id);
        return $this->update($data, $where);

    }

    public function deleteUser($id)
    {
        $this->delete('id =' . (int)$id);
        return "1";
    }

    public function getLatest()
    {
        $select = $this->select();
        $select->limit(1);
        $select->order('created desc');
        return $this->fetchAll($select);
    }
    public function getUsers(){
        return $this->fetchAll()->toArray();
    }
    public function checkUsernameExists($username)
    {
        $return = $this->fetchAll($this->select()->where('username=?', $username))->toArray();
        /** Pievienojam mainīgajam, jo empty() māk pārbaudīt tikai mainīgos. */
        return !empty($return);
    }
    public function approve($id){
        $data['isApproved'] = 1;
        $where = $this->getAdapter()->quoteInto('userId = ?', $id);
        $this->update($data, $where);
    }
    public function disapprove($id){
        $data['isApproved'] = 0;
        $where = $this->getAdapter()->quoteInto('userId = ?', $id);
        $this->update($data, $where);
    }


}

?>