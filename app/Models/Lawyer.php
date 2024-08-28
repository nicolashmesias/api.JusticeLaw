<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Lawyer as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Lawyer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_names',
        'type_document_id',
        'document_number',
        'email',
        'password',
    ];


    const REGISTRO_CIVIL_DE_NACIMIENTO = 1;
    const TARJETA_DE_IDENTIDAD = 2;
    const TARJETA_EXTRANJERIA = 3;
    const CEDULA_CIUDADANIA = 4;
    const NIT = 5;
    const PASAPORTE = 6;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $allowIncluded = ['typeDocument','lawyerProfile', 'verificationLawyer','verificationLawyer.country','verificationLawyer.state','verificationLawyer.city','areas','reviews.user','answers','notifications','searches','searches.information'];

    protected $allowFilter = ['id', 'name', 'last_names','type_document_id', 'document_number', 'email', 'password'];


    public function typeDocument(){
        return $this->belongsTo(TypeDocument::class);
    }

    public function lawyerProfile(){
        return $this->hasOne(LawyerProfile::class);
    }

    public function verificationLawyer(){
        return $this->hasOne(VerificationLawyer::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function searches(){
        return $this->hasMany(Search::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_lawyers', 'lawyer_id', 'area_id');
    }

    public function dates(){
        return $this->belongsToMany(Date::class);
    }

    public function scopeIncluded(Builder $query)
    {

        if(empty($this->allowIncluded)||empty(request('included'))){// validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            return;
        }

        $relations = explode(',', request('included')); //['posts','relation2']//recuperamos el valor de la variable included y separa sus valores por una coma

       // return $relations;

        $allowIncluded = collect($this->allowIncluded); //colocamos en una colecion lo que tiene $allowIncluded en este caso = ['posts','posts.user']

        foreach ($relations as $key => $relationship) { //recorremos el array de relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

        //http://api.codersfree1.test/v1/categories?included=posts


    }

    public function scopeFilter(Builder $query)
    {

        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {

            if ($allowFilter->contains($filter)) {

                $query->where($filter, 'LIKE', '%' . $value . '%');//nos retorna todos los registros que conincidad, asi sea en una porcion del texto
            }
        }

        //http://api.codersfree1.test/v1/categories?filter[name]=depo
        //http://api.codersfree1.test/v1/categories?filter[name]=posts&filter[id]=2

    }

}
