<?php

class Customer_Model_CustomerMapper
{
    const MSG_ERR_INVALID_DATA_PROVIDER = 'customer_mapper.error.invalid_data_provider';
    const MSG_ERR_CUSTOMER_NOT_FOUND    = 'customer_mapper.error.not_found';

    protected $dataProvider;

    public function setDataProvider($dataProvider)
    {
        if (is_string($dataProvider)) {
            $dataProvider = new $dataProvider();
        }
        if (!$dataProvider instanceof Zend_Db_Table_Abstract) {
            throw new Exception(self::MSG_ERR_INVALID_DATA_PROVIDER);
        }
        $this->dataProvider = $dataProvider;

        return $this;
    }

    /**
     * Return data provider
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getDataProvider()
    {
        if (null === $this->dataProvider) {
            $this->setDataProvider('Customer_Model_DbTable_Customers');
        }

        return $this->dataProvider;
    }

    public function save(Customer_Model_Customer $customer)
    {
        $data = array(
            'ref_client' => $customer->getId(),
            'titre' => $customer->titre,
            'nom' => $customer->nom,
            'prenom' => $customer->prenom,
            'societe' => $customer->societe,
            'ref_adr' => $customer->ref_adr,
            'ref_adr_fact' => $customer->ref_adr_fact,
            'num_tva' => $customer->num_tva,
            'ref_externe' => $customer->ref_externe,
        );

        if (null === ($id = $customer->getId())) {
            unset($data['ref_client']);
            $this->getDataProvider()->insert($data);
        } else {
            $this->getDataProvider()->update(array('ref_client = ?' => $id));
        }
    }

    public function get($id)
    {
        $result = $this->getDataProvider()->find($id);
        if (0 == count($result)) {
            throw new Exception(self::MSG_ERR_CUSTOMER_NOT_FOUND);
        }

        $customer = new Customer_Model_Customer;
        foreach ($result as $row) {
            foreach ($row as $name => $value) {
                if ($name == 'ref_client') {
                    $name = 'id';
                }
                $customer->$name = $value;
            }
            break;
        }

        return $customer;
    }

}