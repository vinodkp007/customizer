<?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>

    <main id="mainContent"></main>

    <button class="admin-toggle" id="adminToggle">Admin</button>
    <div class="admin-panel" id="adminPanel">
        <h2>Admin Panel</h2>
        <form class="admin-form" id="navForm">
            <h3>Add Navigation Link</h3>
            <input type="text" placeholder="Link Text" id="linkText">
            <select id="pageType">
                <option value="container">Container Page</option>
                <option value="simple">Simple Page</option>
            </select>
            <button type="submit">Add Link</button>
        </form>
    </div>

<?= $this->include('partials/footer') ?>