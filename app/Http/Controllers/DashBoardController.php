<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DashBoard;
class DashBoardController extends Controller
{
    public function addMemo(Request $request)
    {
        $this->validate($request, [
            'memo' => 'required'
        ]);
        return DashBoard::create([
            'memo' => $request->memo
        ]);
    }

    public function getMemo(Request $request)
    {
        return DashBoard::orderBy('id', 'desc')->get();
    }

    public function editMemo(Request $request)
    {
        $this->validate($request, [
            'memo' => 'required',
        ]);
        dump($request->memo);
        return DashBoard::where('id', $request->id)->update([
            'memo' => $request->memo
        ]);
    }

    public function deleteMemo(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return DashBoard::where('id', $request->id)->delete();
    }
}
