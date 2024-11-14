<style>
    .pagination .page-item .page-link {
        color: #007bff;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        color: #0056b3;
    }
</style>

<div class="container mt-5">
    <h2>Activity Log</h2>

    <form method="get" action="<?= base_url('home/activity') ?>" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search Activity"
                    value="<?= esc($search) ?? '' ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="id_user" class="form-control" placeholder="User ID"
                    value="<?= esc($userId) ?? '' ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="<?= esc($startDate) ?? '' ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="<?= esc($endDate) ?? '' ?>">
            </div>
            <div class="col-md-2">
                <select name="limit" class="form-control">
                    <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th>
                <th>Activity</th>
                <th>Timestamp</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activity_logs as $index => $log): ?>
                <tr>
                    <td><?= ($index + 1) + ($limit * ($pager->getCurrentPage() - 1)) ?></td>
                    <td><?= esc($log['id_user']) ?></td>
                    <td><?= esc($log['activity']) ?></td>
                    <td><?= esc($log['timestamp']) ?></td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Delete log?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>