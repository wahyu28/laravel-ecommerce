<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'slug'];

    //MUTATOR
    //dimana fungsi tersebut bekerja untuk memodifikasi data sebelum data tersebut disimpan kedalam database.
    // mutator sendiri memiliki karakter nama method-nya adalah setNamaFieldAttribute()
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    //ACCESSOR
    //berlaku sebaliknya, formatting-nya dilakukan setelah data diterima dari database dan karakter nama method-nya
    //accessor sendiri memiliki karakter nama method-nya adalah getNamaFieldAttribute().
    public function getNameAttributes($value)
    {
        return ucfirst($value);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetParent($query)
    {
        //SEMUA QUERY YANG MENGGUNAKAN LOCAL SCOPE INI AKAN SECARA OTOMATIS DITAMBAHKAN KONDISI whereNull('parent_id)
        return $query->whereNull('parent_id');

        // Local scope digunakan untuk mengelompokkan query yang bisa digunakan kembali pada kondisi lain
        // sehingga kita tidak perlu menuliskan kembali query tersebut.
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
