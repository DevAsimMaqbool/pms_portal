@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
  /* Center the whole game vertically and horizontally */
  .game-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
  }

  /* Game box styling */
  .game-box {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    width: 50%;
  }

  .board {
    display: grid;
    grid-template-columns: repeat(3, 100px);
    gap: 10px;
    justify-content: center;
    margin: 0 auto;
  }

  .cell {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    background-color: #fafafa;
    border: 2px solid #ccc;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .cell:hover:not(.disabled) {
    background-color: #f5f5f5;
    transform: scale(1.05);
  }

  .cell.disabled {
    pointer-events: none;
    opacity: 0.6;
  }

  .status-text {
    font-size: 1.2rem;
    color: #333;
    font-weight: 500;
  }

  #restart {
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 10px;
  }
</style>
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="game-container">
  <div class="game-box text-center">
    <h2 class="mb-3">🎮 Tic Tac Toe — You vs AI 🤖</h2>

    <div class="board" id="board"></div>

    <div id="status" class="status-text mt-3">Your turn (X)</div>

    <button id="restart" class="btn btn-primary mt-4">Restart Game</button>
  </div>
</div>

    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
@endpush
@push('script')
<script>
(() => {
  const boardEl = document.getElementById('board');
  const statusEl = document.getElementById('status');
  const restartBtn = document.getElementById('restart');

  let board = Array(9).fill('');
  const human = 'X';
  const ai = 'O';

  const winPatterns = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];

  function renderBoard() {
    boardEl.innerHTML = '';
    board.forEach((cell, i) => {
      const div = document.createElement('div');
      div.classList.add('cell');
      if (cell) div.classList.add('disabled');
      div.textContent = cell;
      div.addEventListener('click', () => handleCellClick(i));
      boardEl.appendChild(div);
    });
  }

  function handleCellClick(index) {
    if (board[index] || checkWinner(board)) return;
    board[index] = human;
    renderBoard();

    if (checkWinner(board)) {
      showAlert('You Win 🎉', 'Great job beating the AI!', 'success');
      disableBoard();
      return;
    }

    if (isDraw()) {
      showAlert('Draw 😐', 'It’s a tie — well played!', 'info');
      return;
    }

    statusEl.textContent = 'AI thinking...';
    setTimeout(aiMove, 400);
  }

  function aiMove() {
    const best = findBestMove(board);
    if (best !== null) board[best] = ai;
    renderBoard();

    if (checkWinner(board)) {
      showAlert('AI Wins 🤖', 'Better luck next time!', 'error');
      disableBoard();
      return;
    }

    if (isDraw()) {
      showAlert('Draw 😐', 'It’s a tie — well played!', 'info');
      return;
    }

    statusEl.textContent = 'Your turn (X)';
  }

  function isDraw() {
    return board.every(cell => cell !== '') && !checkWinner(board);
  }

  function checkWinner(b) {
    for (const [a, b1, c] of winPatterns) {
      if (b[a] && b[a] === b[b1] && b[a] === b[c]) return b[a];
    }
    return null;
  }

  // Minimax AI (perfect play)
  function findBestMove(b) {
    let bestScore = -Infinity;
    let move = null;
    b.forEach((cell, i) => {
      if (!cell) {
        b[i] = ai;
        const score = minimax(b, 0, false);
        b[i] = '';
        if (score > bestScore) {
          bestScore = score;
          move = i;
        }
      }
    });
    return move;
  }

  function minimax(b, depth, isMaximizing) {
    const winner = checkWinner(b);
    if (winner === ai) return 10 - depth;
    if (winner === human) return depth - 10;
    if (b.every(c => c !== '')) return 0;

    if (isMaximizing) {
      let best = -Infinity;
      b.forEach((cell, i) => {
        if (!cell) {
          b[i] = ai;
          best = Math.max(best, minimax(b, depth + 1, false));
          b[i] = '';
        }
      });
      return best;
    } else {
      let best = Infinity;
      b.forEach((cell, i) => {
        if (!cell) {
          b[i] = human;
          best = Math.min(best, minimax(b, depth + 1, true));
          b[i] = '';
        }
      });
      return best;
    }
  }

  function disableBoard() {
    document.querySelectorAll('.cell').forEach(c => c.classList.add('disabled'));
  }

  // SweetAlert2 popup helper
  function showAlert(title, text, icon) {
    Swal.fire({
      title,
      text,
      icon,
      confirmButtonText: 'Play Again',
      customClass: {
        confirmButton: 'btn btn-primary'
      },
      buttonsStyling: false
    }).then(() => restartGame());
  }

  function restartGame() {
    board = Array(9).fill('');
    renderBoard();
    statusEl.textContent = 'Your turn (X)';
  }

  restartBtn.addEventListener('click', () => {
    Swal.fire({
      title: 'Restart Game?',
      text: 'Your current game progress will be lost.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, restart',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'btn btn-danger me-2',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false
    }).then(result => {
      if (result.isConfirmed) restartGame();
    });
  });

  renderBoard();
})();
</script>

@endpush