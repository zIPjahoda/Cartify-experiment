<?php

class HledatController extends Controller
{
    function doIs($params)
    {
        $searchManager = new SearchManager();
        if (isset($_REQUEST['query'])) {
            $query = $_REQUEST['query'];

            $sql = $searchManager->returnSearchText('allspec', $query);
            $array = array();
            while ($sql) {
                $array[] = array(
                    'label' => $sql['nameGame'],
                    'value' => $sql['nameGame'],
                );
                // TODO: Implement doIs() method.
            }
        }
        //RETURN JSON ARRAY
        $this->data[""] = json_encode($array);
    }
}
?>