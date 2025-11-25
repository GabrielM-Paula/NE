<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once '../includes/db_connection.php';

$id_usuario = $_SESSION['user_id'];
$id_ideia = $_GET['id'] ?? null;

if (!$id_ideia) {
    die("Projeto não encontrado.");
}

// Buscar os dados da ideia
$sql = "SELECT nome, descricao, tempo_hora 
        FROM ideia 
        WHERE id_ideia = ? AND id_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_ideia, $id_usuario]);
$ideia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ideia) {
    die("Projeto não encontrado ou não pertence a este usuário.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($ideia['nome']) ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/Descricao.css">
</head>
<body>
   <div class="container">

    <!-- TOPO -->
    <div class="header">
        <div class="back-btn">
            <a href="meusProjetos.php"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="logo">
            <div class="logo-placeholder">NE</div>
        </div>
    </div>

    <!-- STATUS ORIGINAL -->
    <div class="status">
        <h2>
            <span id="projectName"><?= htmlspecialchars($ideia['nome']) ?></span>
            <i class="fas fa-pen" id="editar"></i>
        </h2>
        <span class="tag">Em andamento</span>
    </div>

    <!-- DATA -->
    <div class="date">
        <i class="far fa-calendar"></i>
        <span>Criado em <?= date("d/m/Y H:i", strtotime($ideia['tempo_hora'])) ?></span>
    </div>

    <!-- NOVO STATUS -->
    <div class="status-center">
        <button class="status-btn" id="statusToggle">
            Alterar Status <i class="fas fa-chevron-down"></i>
        </button>

        <div class="dropdown" id="dropdownMenu">
            <span class="opt">Em andamento</span>
            <span class="opt">Concluído</span>
        </div>
    </div>

    <!-- CARD -->
    <div class="card">
        <h3><i class="fas fa-align-left"></i> Descrição</h3>
        <textarea id="projectDesc" readonly><?= htmlspecialchars($ideia['descricao']) ?></textarea>

        <div class="edit-buttons" id="editButtons" style="display:none;">
            <button class="save" id="saveBtn">Salvar</button>
            <button class="cancel" id="cancelBtn">Cancelar</button>
        </div>
    </div>

    <!-- TOOLS -->
    <div class="tool">
        <div class="info">
            <div class="tool-icon"><i class="fas fa-palette"></i></div>
            <div><h4>Canva</h4></div>
        </div>
        <i class="fas fa-chevron-right"></i>
    </div>

    <div class="tool">
        <div class="info">
            <div class="tool-icon"><i class="fas fa-chalkboard"></i></div>
            <div><h4>Pitch</h4></div>
        </div>
        <i class="fas fa-chevron-right"></i>
    </div>

    <button class="add-btn"><i class="fas fa-plus"></i></button>

    <form action="deleteProjeto.php" method="POST">
        <input type="hidden" name="id" value="<?= $id_ideia ?>">
        <button class="del-btn"><i class="fas fa-trash"></i></button>
    </form>

    <form action="arquivarProjeto.php" method="POST">
    <input type="hidden" name="id" value="<?= $id_ideia ?>">
    <button class="del-btn" style="background:#666;"><i class="fas fa-box-archive"></i></button>
</form>


</div>


<script>
// ===== DROPDOWN =====
const toggle = document.getElementById("statusToggle");
const menu = document.getElementById("dropdownMenu");

toggle.addEventListener("click", () => {
    menu.classList.toggle("show");
});

document.querySelectorAll(".opt").forEach(opt => {
    opt.addEventListener("click", () => {

        let valor = opt.innerText === "Concluído"
            ? "concluida"
            : "em_progresso";

        fetch("updateStatus.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=<?= $id_ideia ?>&progresso=${valor}`
        })
        .then(r => r.text())
        .then(resp => {
            if (resp.trim() === "ok") {
                toggle.innerHTML = opt.innerText + " <i class='fas fa-chevron-down'></i>";
                menu.classList.remove("show");
            } else {
                alert("Erro ao atualizar status.");
            }
        });
    });
});

document.addEventListener("click", (e) => {
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove("show");
    }
});

  const editBtn = document.getElementById("editar");
  const nameSpan = document.getElementById("projectName");
  const descArea = document.getElementById("projectDesc");
  const editButtons = document.getElementById("editButtons");
  const saveBtn = document.getElementById("saveBtn");
  const cancelBtn = document.getElementById("cancelBtn");

  let originalName = nameSpan.textContent;
  let originalDesc = descArea.value;
  let editing = false;

  editBtn.addEventListener("click", () => {
    if (!editing) {
      // Ativar edição
      editing = true;
      const input = document.createElement("input");
      input.type = "text";
      input.id = "projectNameInput";
      input.value = originalName;
      input.style.fontSize = "22px";
      input.style.fontWeight = "700";
      input.style.border = "1px solid #cbd5e1";
      input.style.borderRadius = "6px";
      input.style.padding = "4px 8px";

      nameSpan.replaceWith(input);
      descArea.removeAttribute("readonly");
      editButtons.style.display = "flex";
    }
  });

  cancelBtn.addEventListener("click", () => {
    if (editing) {
      // Restaurar
      editing = false;
      const input = document.getElementById("projectNameInput");
      const span = document.createElement("span");
      span.id = "projectName";
      span.textContent = originalName;

      input.replaceWith(span);
      descArea.value = originalDesc;
      descArea.setAttribute("readonly", true);
      editButtons.style.display = "none";
    }
  });

  saveBtn.addEventListener("click", () => {
    if (editing) {
      const input = document.getElementById("projectNameInput");
      const newName = input.value.trim();
      const newDesc = descArea.value.trim();

      // Enviar via fetch para salvar no banco
      fetch("updateProjeto.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=<?= $id_ideia ?>&nome=${encodeURIComponent(newName)}&descricao=${encodeURIComponent(newDesc)}`
      })
      .then(res => res.text())
.then(data => {
    data = data.trim(); // Remove espaços extras
    if (data === "ok") {
        // Atualizar originais
        originalName = newName;
        originalDesc = newDesc;

        const span = document.createElement("span");
        span.id = "projectName";
        span.textContent = newName;

        input.replaceWith(span);
        descArea.setAttribute("readonly", true);
        editButtons.style.display = "none";
        editing = false;
    } else {
        alert("Erro ao salvar alterações.");
        console.log(data); // Opcional: ver o que o PHP está retornando
    }
});

    }
  });
</script>
</body>
</html>
