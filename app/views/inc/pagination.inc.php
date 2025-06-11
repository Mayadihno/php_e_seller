  <?php if ($totalPages > 1): ?>
      <nav class="mt-3" aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
              <?php if ($page > 1): ?>
                  <li class="page-item">
                      <a class="page-link" href="<?= $uri; ?>?<?= http_build_query(['page' => $page - 1]); ?>">Previous</a>
                  </li>
              <?php endif; ?>
              <?php for ($x = 1; $x <= $totalPages; $x++): ?>
                  <li class="page-item">
                      <a class="page-link <?php if ($x === $page) echo 'active'; ?>" href="<?= $uri; ?>?<?= http_build_query(['page' => $x]); ?>">
                          <?= $x; ?>
                      </a>
                  </li>
              <?php endfor; ?>
              <?php if ($page < $totalPages): ?>
                  <li class="page-item">
                      <a class="page-link" href="<?= $uri; ?>?<?= http_build_query(['page' => $page + 1]); ?>">Next</a>
                  </li>
              <?php endif; ?>
          </ul>
      </nav>
  <?php endif; ?>