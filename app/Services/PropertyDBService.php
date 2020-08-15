<?php


namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyDBService
{
    private $db;
    private $query_insert;
    private $table_name;

    public function __construct()
    {
        $this->property_table = app('db')->table("properties");
    }

    // Todo
    public function handleSearchConditions(Request $request)
    {
        $conditions = [];
        //Todo Handle business logic for handle conditions
        if ($request->has("state")) {
            if (!empty($request->get("state"))) {
                $conditions[] = ["state", "=", $request->get("state")];
            }
        }

        if ($request->has("b2b_partner")) {
            if (!empty($request->get("b2b_partner"))) {
                $conditions[] = ["b2b_partner", "=", $request->get("b2b_partner")];
            }
        }
        return $conditions;
    }

    public function generate_array($type)
    {
        $type_arr = explode(",", $type);
        return $type_arr;
    }

    public function convertURL($str)
    {
        $hash = ["amp;", "gt;", "lt;", "quot;", "#039;", "plus;"];
        $values = ["&", "<", ">", '"', "'", "+"];


        return str_replace($hash, $values, $str);

    }

    public function getPriceRange(Request $request)
    {
        $conditions = [];
        if ($request->has("min_price")) {
            if (!empty($request->get("min_price"))) {
                $conditions[] = ["from_price", ">=", (float)$request->get("min_price")];
            }
        }
        if ($request->has("max_price")) {
            if (!empty($request->get("max_price"))) {
                $conditions[] = ["to_price", "<=", (float)$request->get("max_price")];
            }
        }
        return $conditions;
    }

    public function getStatus(Request $request)
    {
        $status = ["status", "!=", "Sold"];
        if ($request->has("status")) {
            if (!empty($request->get("status"))) {
                if ($request->get("status") === "Sold") {
                    $status = ["status", "=", "Sold"];
                }
            }
        }
        return [$status];
    }

    public function generateWhereInRequest($request, $type)
    {
        $results = [];
        if ($request->has($type)) {
            $parameters = $request->get($type);
            if (!empty($parameters)) {
                $results = explode(",", $this->convertURL($parameters));
            }
        }
        return $results;
    }


    public function getPropertiesFromDB(Request $request)
    {
        $property_type = $this->generateWhereInRequest($request, "property_type");
        $strategy_type = $this->generateWhereInRequest($request, "strategy_type");


        $conditions = array_merge($this->handleSearchConditions($request),
            $this->getPriceRange($request),
            $this->getStatus($request)
        );


        $property_query = $this->property_table
            ->where($conditions)
            ->where("status", "!=", "Off Market")
            ->where("status", "!=", "Selling Fast");

        if (!empty($property_type)) {
            $property_query = $property_query->whereIn("property_type", $property_type);
        }

        if (!empty($strategy_type)) {
            $property_query = $property_query->whereIn("strategy_type", $strategy_type);
        }

        $keyword = $request->get("keyword");

        $orderBy = $request->has("orderBy") ? $request->get("orderBy") : "from_price";
        $orderType = $request->has("orderType") ? $request->get("orderType") : "asc";

        if (!empty($keyword)) {

            $keyword_arr = explode(",", $keyword);

            if (is_numeric($keyword_arr[0])) {
                $property_query = $property_query->where("display_id", "=", Str::lower($keyword));
            } else {
                $property_query = $property_query->where(function ($query) use ($keyword, $keyword_arr) {
                    $suburb = $keyword_arr[0];
                    $state = "";
                    $postcode = "";

                    if (count($keyword_arr) === 3) {
                        $state = "%" . $keyword_arr[1] . "%";
                        $postcode = "%" . $keyword_arr[2] . "%";
                    }

                    $query->orWhere("suburb", "LIKE", "%{$suburb}%")
                        ->orWhere("postcode", "LIKE", "{$postcode}")
                        ->orWhere("state", "LIKE", "{$state}")
                        ->orWhere("title", "LIKE", "%{$keyword}%");
                });
            }

        }

        $property_results = $property_query->orderBy($orderBy, $orderType)->paginate(10);

        $properties_list = $property_results->getCollection()->transform(function ($property) {
            if ($property->attachments !== "") {
                $property->attachments = unserialize($property->attachments);
            }
            return $property;
        });
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $properties_list,
            $property_results->total(),
            $property_results->perPage(),
            $property_results->currentPage()
        );
    }

    public function getSuggestedKeyword($keyword, $state = '')
    {
//        $state = strtoupper(!empty($state) ? $state : $keyword);
//        if (strtoupper($keyword) === $state):
//              $keyword = "";
//        endif;
//
//        return $this->property_table->select("suburb", "state", "postcode")
//            ->distinct()
//            ->where('suburb', 'LIKE', "{$keyword}%")
//            ->orWhere('postcode', 'LIKE', "{$keyword}%")
//            ->orWhere("state", "LIKE", "{$state}%")
//            ->get();

        if(empty($state)){
            return $this->property_table->select("suburb", "state", "postcode")
            ->distinct()
            ->where('suburb', 'LIKE', "{$keyword}%")
            ->orWhere('postcode', 'LIKE', "{$keyword}%")
            ->orWhere("state", "LIKE", "{$keyword}%")
            ->get();
        }else{
            return $this->property_table->select("suburb", "state", "postcode")
            ->distinct()
            ->where('suburb', 'LIKE', "{$keyword}%")
            ->orWhere('postcode', 'LIKE', "{$keyword}%")
            ->where("state", "LIKE", "{$state}%")
            ->get();
        }





    }

    public function getSingleProperty($display_id)
    {
        $property = $this->property_table->select("*")
            ->where("display_id", $display_id)
            ->first();
        if ($property) {
            if ($property->attachments !== "") {
                $property->attachments = unserialize($property->attachments);
            }
            $property->lists = $this->getChildListing((int)$property->property_id);

            if (intval($property->parent_property_id) !== 0) {
                $property->parent_property_data = $this->getParentPropertyData($property->parent_property_id);

                if ($property->parent_property_data && $property->parent_property_data->attachments !== "") {
                    $property->parent_property_data->attachments = unserialize($property->parent_property_data->attachments);
                }
            }
        }

        return $property;
    }


    public function getChildListing($property_id)
    {

        return app('db')->table("properties")->select("*")
            ->where("parent_property_id", $property_id)
            ->where("status", "!=", "Off Market")
            ->where("status", "!=", "Sold")
            ->orderBy("from_price", "asc")
            ->get();
    }

    public function getParentPropertyData($parent_property_id)
    {
        return app('db')->table("properties")->select("display_id", "attachments")
            ->where("property_id", $parent_property_id)
            ->first();
    }

    public function getInitialData()
    {
        $property_types = $this->property_table->select("property_type")->distinct()->where("property_type", "!=", "")->get()->pluck('property_type');
        $strategy_types = $this->property_table->select(["strategy_type"])->distinct()->where("strategy_type", "!=", "")->get()->pluck("strategy_type");

        return compact("property_types", "strategy_types");
    }

    public function getB2BPartners()
    {
        $b2b_partners = $this->property_table->select(["b2b_partner"])->distinct()->where("b2b_partner", "!=", "")->get()->pluck("b2b_partner");
        return compact("b2b_partners");
    }

    public function getPropertyAddress()
    {
        return $this->property_table->select("property_id", "address", "location")
            ->where("status", "!=", "Off Market")
            ->limit(100)->get();
    }
}
