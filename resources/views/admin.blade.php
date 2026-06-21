<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Panel Administrativo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .card-stat{
    background: linear-gradient(
        135deg,
        #0d1736,
        #13224d
    );

    border: 2px solid #ffd700;

    border-radius: 20px;

    box-shadow:
        0 0 15px rgba(255,215,0,.3),
        0 0 30px rgba(255,215,0,.15);

    transition: .3s;
}

.card-stat:hover{
    transform: translateY(-5px);

    box-shadow:
        0 0 20px rgba(255,215,0,.5),
        0 0 40px rgba(255,215,0,.25);
}

.card-stat h5{
    color:#ffd700;
    font-weight:700;
    text-transform:uppercase;
}

.card-stat h1{
    color:white;
    font-size:3rem;
    font-weight:900;
}
    .sidebar{
    position:relative;
    overflow:hidden;
    height:100vh;
    background:#07112b;
    padding:20px;
}

#money-container{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    pointer-events:none;
}

.money-rain{
    position:absolute;
    top:-50px;
    z-index:1;
    animation:fall linear forwards;
}

.sidebar h3,
.sidebar hr,
.sidebar button{
    position:relative;
    z-index:2;
}

@keyframes fall{

    from{
        transform:
            translateY(-50px)
            rotate(0deg);
    }

    to{
        transform:
            translateY(110vh)
            rotate(360deg);
    }
}

body{
    background:#f5f7fb;
}

.sidebar{
    height:100vh;
    background:#0f172a;
    color:white;
    padding:20px;
}

.sidebar h3{
    
    font-weight:bold;
}

.sidebar button{
    width:100%;
    margin-bottom:10px;
}


.table-container{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 3px 12px hsla(252, 97%, 12%, 0.88);
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- panel izquierdo -->
<div class="col-md-2 sidebar">

    <div id="money-container"></div>

    <h3>MILLONARIO</h3>

    <hr>

    <button class="btn btn-primary"
        onclick="loadCategories()">
        Categorías
    </button>

    <button class="btn btn-success"
        onclick="loadQuestions()">
        Preguntas
    </button>

</div>

<!-- CONTENIDO -->

<div class="col-md-10 p-4">

<h2>Panel Administrativo</h2>

<div class="row mt-4">

<div class="col-md-4">

<div class="card card-stat">

<div class="card-body text-center">

<h5>Categorías</h5>

<h1 id="totalCategories">5</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card card-stat">

<div class="card-body text-center">

<h5>Preguntas</h5>

<h1 id="totalQuestions">17</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card card-stat">

<div class="card-body text-center">

<h5>Partidas</h5>

<h1 id="totalGames">0</h1>

</div>

</div>

</div>

</div>

<div class="table-container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">

<h4 id="sectionTitle">

Categorías

</h4>

<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#createCategoryModal">

Nueva Categoría

</button>

</div>

<div id="content"></div>

</div>

</div>

</div>

</div>

<!-- MODAL CREAR -->

<div class="modal fade" id="createCategoryModal">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5>Nueva Categoría</h5>

<button
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<input
type="text"
id="newCategoryName"
class="form-control"
placeholder="Nombre de la categoría">

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal">

Cancelar

</button>

<button
class="btn btn-primary"
onclick="createCategory()">

Guardar

</button>

</div>

</div>

</div>

</div>

<!-- MODAL EDITAR -->

<div class="modal fade" id="editCategoryModal">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5>Editar Categoría</h5>

<button
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<input
type="hidden"
id="editCategoryId">

<input
type="text"
id="editCategoryName"
class="form-control">

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal">

Cancelar

</button>

<button
class="btn btn-success"
onclick="updateCategory()">

Actualizar

</button>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

async function loadDashboard(){

    const categories =
        await fetch('/api/categories');

    const categoriesData =
        await categories.json();

    const questions =
        await fetch('/api/questions');

    const questionsData =
        await questions.json();
async function loadDashboard(){

    const categoriesResponse = await fetch('/api/categories');
    const categoriesData = await categoriesResponse.json();

    let totalQuestions = 0;

    categoriesData.forEach(category => {
        totalQuestions += category.questions.length;
    });

    document.getElementById('totalCategories').innerText =
        categoriesData.length;

    document.getElementById('totalQuestions').innerText =
        totalQuestions;

    document.getElementById('totalGames').innerText = '-';
}
    
}

async function loadCategories(){

    document.getElementById('sectionTitle')
        .innerText = 'Categorías';

    const response =
        await fetch('/api/categories');

    const categories =
        await response.json();

    let html = `

    <table class="table table-bordered table-hover">

    <thead>

    <tr>

        <th>ID</th>
        <th>Nombre</th>
        <th>Preguntas</th>
        <th>Acciones</th>

    </tr>

    </thead>

    <tbody>
    `;

    categories.forEach(cat => {

        html += `

        <tr>

            <td>${cat.id}</td>

            <td>${cat.name}</td>

            <td>${cat.questions.length}</td>

            <td>

                <button
                class="btn btn-warning btn-sm"
                onclick="openEditCategory(
                ${cat.id},
                '${cat.name}'
                )">

                Editar

                </button>

                <button
                class="btn btn-danger btn-sm"
                onclick="deleteCategory(
                ${cat.id}
                )">

                Eliminar

                </button>

            </td>

        </tr>
        `;
    });

    html += `
    </tbody>
    </table>
    `;

    document.getElementById('content')
        .innerHTML = html;
}

async function loadQuestions(){

    document.getElementById('sectionTitle')
        .innerText = 'Preguntas';

    const response =
        await fetch('/api/questions');

    const questions =
        await response.json();

    let html = `

    <table class="table table-bordered table-hover">

    <thead>

    <tr>

        <th>ID</th>
        <th>Categoría</th>
        <th>Pregunta</th>
        <th>Puntos</th>
        <th>Tiempo</th>

    </tr>

    </thead>

    <tbody>
    `;

    questions.forEach(q => {

        html += `

        <tr>

            <td>${q.id}</td>

            <td>${q.category.name}</td>

            <td>${q.question}</td>

            <td>${q.points}</td>

            <td>${q.time_limit}</td>

        </tr>

        `;
    });

    html += `
    </tbody>
    </table>
    `;

    document.getElementById('content')
        .innerHTML = html;
}

async function createCategory(){

    const name =
        document.getElementById('newCategoryName')
        .value
        .trim();

    if(name === ''){

        Swal.fire({
            icon:'warning',
            title:'Campo obligatorio',
            text:'Ingrese un nombre'
        });

        return;
    }

    const response = await fetch(
        '/api/categories',
        {
            method:'POST',

            headers:{
                'Content-Type':'application/json'
            },

            body:JSON.stringify({
                name:name
            })
        }
    );

    if(response.ok){

        Swal.fire({
            icon:'success',
            title:'Categoría creada'
        });

        document.getElementById(
            'newCategoryName'
        ).value='';

        bootstrap.Modal
        .getInstance(
            document.getElementById(
                'createCategoryModal'
            )
        )
        .hide();

        loadCategories();
        loadDashboard();

    }else{

        Swal.fire({
            icon:'error',
            title:'Error al crear'
        });

    }
}

function openEditCategory(id,name){

    document.getElementById(
        'editCategoryId'
    ).value=id;

    document.getElementById(
        'editCategoryName'
    ).value=name;

    new bootstrap.Modal(
        document.getElementById(
            'editCategoryModal'
        )
    ).show();
}

async function updateCategory(){

    const id =
        document.getElementById(
            'editCategoryId'
        ).value;

    const name =
        document.getElementById(
            'editCategoryName'
        ).value;

    const response =
        await fetch(
        `/api/categories/${id}`,
        {
            method:'PUT',

            headers:{
                'Content-Type':'application/json'
            },

            body:JSON.stringify({
                name:name
            })
        });

    if(response.ok){

        Swal.fire({
            icon:'success',
            title:'Categoría actualizada'
        });

        bootstrap.Modal
        .getInstance(
            document.getElementById(
                'editCategoryModal'
            )
        )
        .hide();

        loadCategories();

    }else{

        Swal.fire({
            icon:'error',
            title:'Error actualizando'
        });

    }
}

async function deleteCategory(id){

    const result =
        await Swal.fire({

        title:'¿Eliminar categoría?',

        text:'Esta acción no se puede deshacer',

        icon:'warning',

        showCancelButton:true,

        confirmButtonText:'Sí, eliminar',

        cancelButtonText:'Cancelar'

    });

    if(!result.isConfirmed)
        return;

    const response =
        await fetch(
        `/api/categories/${id}`,
        {
            method:'DELETE'
        });

    if(response.ok){

        Swal.fire({
            icon:'success',
            title:'Categoría eliminada'
        });

        loadCategories();
        loadDashboard();

    }else{

        Swal.fire({
            icon:'error',
            title:'No se pudo eliminar'
        });

    }
}
function createMoneyRain() {

    const container =
        document.getElementById('money-container');

    const bill =
        document.createElement('div');

    bill.classList.add('money-rain');

    bill.innerHTML = '💵';

    bill.style.left =
        Math.random() * 180 + 'px';

    bill.style.animationDuration =
        (Math.random() * 4 + 6) + 's';

    bill.style.opacity =
        (Math.random() * 0.4 + 0.2);

    bill.style.fontSize =
        (Math.random() * 15 + 18) + 'px';

    container.appendChild(bill);

    setTimeout(() => {
        bill.remove();
    }, 10000);
}

loadDashboard();
loadCategories();
setInterval(createMoneyRain, 700);
</script>

</body>
</html>