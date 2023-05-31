<?php
class Asset_movement_timeline extends DB_Model
{
    public function get_filtered_data($startDate, $endDate, $criteria)
    {
        if ($startDate == $endDate):
            $condition = [
                'DATE(amt_dateTime)' => $startDate,
            ];
        else:
            $condition = [
                'DATE(amt_dateTime) >=' => $startDate,
                'DATE(amt_dateTime) <=' => $endDate,
            ];
        endif;

        if ($criteria != 'ALL_STORE'):
            $condition['amt_FK_Store_id'] = $criteria;
        endif;

        $this->db->select('*');
        $this->db->from('asset_movement_timeline');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_filtered_data_store_wise($startDate, $endDate, $store_ids)
    {
        if ($startDate == $endDate):
            $condition = [
                'DATE(amt_dateTime)' => $startDate,
            ];
        else:
            $condition = [
                'DATE(amt_dateTime) >=' => $startDate,
                'DATE(amt_dateTime) <=' => $endDate,
            ];
        endif;

        $this->db->select('*');
        $this->db->from('asset_movement_timeline');
        $this->db->where($condition);
        $this->db->where('amt_FK_Store_id IS NOT NULL');

        if ($store_ids[0] != 'ALL_STORE'):
            $this->db->where_in('amt_FK_Store_id', $store_ids);
        endif;

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}
