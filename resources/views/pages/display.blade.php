@extends('layout.default')
@section('title') Display @endsection

@section('top-css')
    <style type="text/css">
        #mynetwork {
            width: 100%;
            height: 40rem;
            border: 1px solid lightgray;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div id="mynetwork"></div>
        </div>
        <div class="col-md-2" id="handle-person">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <button type="submit" class="btn btn-primary mt-2" id="create-person-btn">Personne</button>
                <button type="submit" class="btn btn-primary mt-2" id="create-link-btn">Relation</button>
                <button type="submit" class="btn btn-primary mt-2 disabled" id="details-btn">Détails</button>
            </div>

            <span id="create-person" style="display: none;">
                <h4>Créer une personne</h4>
                <form method="POST" action="{{ route('person.create') }}">
                    @csrf
                    <div class="form-group">
                        <label for="personName">Nom de la personne</label>
                        <input type="text" class="form-control" name="personName" id="personName" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="faction">Faction</label>
                        <select class="form-control selectpicker" name="faction" id="faction" required>
                            @foreach($factions as $faction)
                            <option value="{{ $faction->id }}">{{ $faction->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="picture">Photo de la personne</label>
                        <input type="file" class="form-control-file" name="picture" id="picture" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
                    <button type="reset" class="btn btn-secondary mt-2">Annuler</button>
                </form>
            </span>

            <span id="create-link" style="display: none;">
                <h4>Créer un lien</h4>
                <form method="POST" action="{{ route('relation.create') }}">
                    @csrf
                    <div class="form-group">
                        <label for="personOriginal">Personne originale</label>
                        <select class="form-control" name="personOriginal" id="personOriginal">
                            @foreach($persons as $person)
                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="personLinked">Personne reliée</label>
                        <select class="form-control" name="personLinked" id="personLinked">
                            @foreach($persons as $person)
                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="relation">Relation</label>
                        <select class="form-control" name="relation" id="relation">
                            @foreach($relations_type as $relation)
                                <option value="{{ $relation->id }}">{{ $relation->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
                    <button type="reset" class="btn btn-secondary mt-2">Annuler</button>
                </form>
            </span>

            <div id="details" style="display: none;">
                <h4>Details</h4>
                <form method="POST" action="{{ route('person.update') }}">
                    @csrf
                    <input type="hidden" name="personIDDetails" id="personIDDetails">
                    <div class="form-group">
                        <label for="personNameDetails">Nom de la personne</label>
                        <input type="text" class="form-control" name="personNameDetails" id="personNameDetails" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="factionDetails">Faction</label>
                        <select class="form-control selectpicker" name="factionDetails" id="factionDetails" required>
                            @foreach($factions as $faction)
                                <option value="{{ $faction->id }}">{{ $faction->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newNoteDetails">Nouvelle note</label>
                        <textarea class="form-control" name="newNoteDetails" id="newNoteDetails" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="picture">Photo supplémentaire</label>
                        <input type="file" class="form-control-file" name="picture" id="picture" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <div class="form-group mb-2" id="picturesDetails" style="display: none;">
                        <label>Photos</label>
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators"></div>
                            <div class="carousel-inner"></div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group" id="notesListDetails" style="display: none;">
                        <label>Notes (click it to delete)</label>
                        <span id="listNotesDetails"></span>
                    </div>
                    <div class="form-group" id="relationsDetails" style="display: none;">
                        <label>Relations (click it to delete)</label>
                        <ul id="relationsListDetails"></ul>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Mettre à jour</button>
                </form>
            </span>
        </div>
    </div>
@endsection

@section('bottom-scripts')
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        data = JSON.parse(data);
                        alert('Element created successfully');
                        if(url == "{{ route('person.create') }}") {
                            $('#personOriginal, #personLinked').append($('<option>', {
                                value: data.id,
                                text: data.name
                            }));
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while creating the element');
                    }
                });
            });

            function showMenu(menu) {
                var show = "#create-person";
                var hide = "#create-link, #details";

                if(menu == "create-link") {
                    show = "#create-link";
                    hide = "#create-person, #details";
                } else if(menu == "details") {
                    show = "#details";
                    hide = "#create-person, #create-link";
                }

                $(show).show();
                $(hide).hide();
            }
            $('#create-person-btn').click(function(e) {
                showMenu("create-person");
            });
            $('#create-link-btn').click(function(e) {
                showMenu("create-link");
            });
            $('#details-btn').click(function(e) {
                showMenu("details");
            });

            $(document).on("click", "#listNotesDetails > p", function(e) {
                const p = $(this);
                let id = p.attr('noteID');
                if(confirm("Do you want to delete this note ?\n\n" + p.text())) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('person.deleteNote') }}",
                        data: {"id": id},
                        success: function(data) {
                            p.remove();
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the note');
                        }
                    });
                }
            });
            $(document).on("click", "#relationsListDetails > li", function(e) {
                const li = $(this);
                let id = li.attr('relationID');
                if(confirm("Do you want to delete this relation ?\n\n" + li.text())) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('person.deleteRelation') }}",
                        data: {"id": id},
                        success: function(data) {
                            li.remove();
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the note');
                        }
                    });
                }
            });

            // create an array with nodes
            var nodes = new vis.DataSet([
                @foreach($persons as $person)
                {
                    id: {{ $person->id }},
                    label: "{{ $person->name }}",
                    @if($person->faction_id != null)
                    group: "{{ $person->faction->label }}"
                    @endif
                },
                @endforeach
            ]);

            // create an array with edges
            var edges = new vis.DataSet([
                @foreach($relations as $relation)
                {
                    physics: false,
                    from: {{ $relation->person_id }},
                    to: "{{ $relation->related_person_id }}",
                    @if($relation->relationType != null)
                    label: "{{ $relation->relationType->label }}"
                    @endif
                },
                @endforeach
            ]);

            // create a network
            var container = document.getElementById('mynetwork');

            // provide the data in the vis format
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {
                groups: {
                    @foreach($factions as $faction)
                    "{{ $faction->label }}": { color: { background: "{{ $faction->color }}" } },
                    @endforeach
                }
            };

            // initialize your network!
            var network = new vis.Network(container, data, options);

            // add an event listener for selection change
            network.on("selectNode", function(params) {
                var selectedNodeId = params.nodes[0];

                $.ajax({
                    type: 'POST',
                    url: "{{ route('person.load') }}",
                    data: {"id": selectedNodeId},
                    success: function(data) {
                        data = JSON.parse(data);
                        showMenu("details");
                        console.log(data);

                        if(data.details.notes.length > 0) {
                            $('#notesListDetails').show();
                            $('#listNotesDetails').empty();
                            data.details.notes.forEach((element, index) => {
                                $('#listNotesDetails').append("<p noteID='" + element.id + "'>" + element.text + "</p>");
                                if(data.details.notes.length > 1 && index != (data.details.notes.length-1)) {
                                    $('#listNotesDetails').append("<hr>");
                                }
                            });
                        } else {
                            $('#notesListDetails').hide();
                        }

                        if(data.relations.length > 0) {
                            $('#relationsDetails').show();
                            $('#relationsListDetails').empty();
                            data.relations.forEach((element, index) => {
                                $('#relationsListDetails').append("<li relationID='" + element.id + "'>" + element.person.name + " -> " + element.related_person.name + " : " + element.relation_type.label + "</li>");
                            });
                        } else {
                            $('#relationsDetails').hide();
                        }

                        $('#details-btn').removeClass("disabled");
                        $('#personIDDetails').val(data.details.id);
                        $('#personNameDetails').val(data.details.name);
                        $('#factionDetails option[value="' + data.details.faction_id + '"]').prop('selected', true);
                        if(data.details.images.length > 0) {
                            $('#picturesDetails').show();

                            var carouselInner = $('#carouselExampleIndicators .carousel-inner');
                            var carouselIndicators = $('#carouselExampleIndicators .carousel-indicators');
                            carouselInner.empty();
                            carouselIndicators.empty();

                            data.details.images.forEach((element, index) => {
                                // Create a new carousel item
                                var item = $('<div class="carousel-item"><img class="d-block w-100"></div>');
                                item.find('img').attr('src', "{{ URL::to('/images') }}/" + element.url);
                                carouselInner.append(item);
                                // If it's the first image, add the active class to the item
                                if (index === 0) {
                                    item.addClass('active');
                                }

                                // Update the carousel indicators
                                var button = $('<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' + index + '"></button>');
                                if (index === 0) {
                                    button.addClass('active');
                                }
                                carouselIndicators.append(button);
                            });
                        } else {
                            $('#picturesDetails').hide();
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while loading the element');
                    }
                });
            });
        });
    </script>
@endsection
