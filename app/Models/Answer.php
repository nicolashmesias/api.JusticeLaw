<?php



namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\NewNotification;
class Answer extends Model
{
    use HasFactory;

    public $fillable=[
        'content',
        'date_publication',
        'lawyer_id',
        'question_id',
        'archive',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }

    public function consultings()
    {
        return $this->hasMany(Consulting::class, 'answer_id');
    }
    protected $allowIncluded = ['questions', 'questions.user','lawyers','lawyer.answers'];

    public function questions(){
        return $this->hasMany('App\Models\Question');
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

    protected static function booted()
{
    static::created(function ($respuesta) {
        // Obtener la pregunta relacionada
        $pregunta = $respuesta->question; // Usa la relación definida correctamente

        // Validar si la pregunta tiene un autor relacionado
        if ($pregunta && $pregunta->user) {
            $autor = $pregunta->user; // Asegúrate de tener la relación 'user' en el modelo Question

            $message = [
                'pregunta_id' => $pregunta->id,
                'titulo_pregunta' => $pregunta->title, // Cambia 'title' si tu columna se llama diferente
                'mensaje' => "Nueva respuesta a tu pregunta: {$pregunta->title}",
            ];

            // Enviar notificación
            $autor->notify(new NewNotification($message)); // Notifica al autor
        }
    });
}

    

}


