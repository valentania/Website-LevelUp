<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PortfolioRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(
        private PortfolioRepositoryInterface $portfolioRepo,
    ) {}

    public function index(Request $request): View
    {
        return view('mahasiswa.portfolio.index', [
            'portfolios' => $this->portfolioRepo->getByUser($request->user()->id, 12),
        ]);
    }

    public function show(int $id): View
    {
        $portfolio = $this->portfolioRepo->findById($id);
        abort_unless($portfolio, 404);

        return view('mahasiswa.portfolio.show', compact('portfolio'));
    }
}
