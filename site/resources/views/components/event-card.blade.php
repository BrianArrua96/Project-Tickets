<!-- resources/views/components/event-card.blade.php -->

<div class="event-card">
    <div class="event-details">
        <h1>{{ $esdeveniment->nom }}</h1>
        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null)
            <h3>{{ $esdeveniment->sesions->first()->data }}</h3>
        @else
            <h3>No hay sesiones</h3>
        @endif
        <h4>{{ $esdeveniment->recinte->lloc }}</h4>
        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty())
            <h2>{{ $esdeveniment->sesions->first()->entrades->first()->preu }} €</h2>
        @else
            <h2>Entradas Agotadas</h2>
        @endif
    </div>
    @if ($esdeveniment->imatge->isNotEmpty())
        <?php
        $imagePath = Storage::url('public/images/' . $esdeveniment->imatge->first()->imatge);
        ?>
        <img src="{{ $imagePath }}" alt="Imatge de l'esdeveniment" loading="lazy">
    @else
        <img src="https://via.placeholder.com/640x480.png/00dd22?text=imagenEvento" alt="Imatge de l'esdeveniment"
            loading="lazy">
    @endif
</div>
