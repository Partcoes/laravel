<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/17
 * Time: 9:27
 */
namespace App\Models;

//use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminResource extends Model
{
    protected $table = 'admin_resource';
    protected $primaryKey = false;
    protected $guarded = [];
    public $timestamps  = false;
    public static function roleGetResource($roleId)
    {
        $resource = self::whereIn('role_id',$roleId) -> get(['type_id','resource_id']) -> toArray();
//        $type_id = array_unique(array_column($resource,'type_id'));
        $type0 = [];
        $type1 = [];
        foreach($resource as $k => $types)
        {
            if($types['type_id'] == 0)
            {
                array_push($type0,$types['resource_id']);
            }elseif($types['type_id'] == 1){
                array_push($type1,$types['resource_id']);
            }
        }
        $data['type0'] = $type0;
        $data['type1'] = $type1;
        return $data;
    }

    public static function updateShipByRole($formInfo,$roleId,$isMenu = 0)
    {
        DB::beginTransaction();
        try{
            $resultForDel = self::where(['role_id'=>$roleId,'type_id'=> $isMenu]) -> delete();
            $findResult = self::where(['role_id'=>$roleId,'type_id'=> $isMenu]) -> get() -> toArray();
            $resultForDel = empty($findResult)?true:$resultForDel;
            $resultForIns = self::insert($formInfo);
            if($resultForDel && $resultForIns){
                DB::commit();
                return true;
            }else{

                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){
            Log::error($e -> getMessage());
            DB::rollBack();
            return false;
        }
    }
//    public static function roleGetResourceById($roleId)
//    {
//        $menus = self::where(['role_id' => $roleId]) -> get() -> toArray();
//        dd($menus);
//    }
}