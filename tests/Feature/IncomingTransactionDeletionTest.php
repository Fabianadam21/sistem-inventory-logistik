<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Department;
use App\Models\IncomingDetail;
use App\Models\IncomingTransaction;
use App\Models\Item;
use App\Models\OutgoingDetail;
use App\Models\OutgoingTransaction;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomingTransactionDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_incoming_transaction_reverses_stock_and_removes_details(): void
    {
        $this->signInAsAdmin();
        [$transaction, $item] = $this->createIncomingTransaction(stock: 12, quantity: 5);

        $this->get(route('reports.incoming'))
            ->assertOk()
            ->assertSee(route('incoming-transactions.destroy', $transaction), false)
            ->assertSee('Hapus transaksi barang masuk', false);

        $this->followingRedirects()
            ->delete(route('incoming-transactions.destroy', $transaction))
            ->assertOk()
            ->assertSee('Transaksi barang masuk berhasil dihapus dan stok telah disesuaikan.')
            ->assertSee('toast--success', false);

        $this->assertSame(7, $item->fresh()->stock);
        $this->assertDatabaseMissing('incoming_transactions', ['id' => $transaction->id]);
        $this->assertDatabaseMissing('incoming_details', [
            'incoming_transaction_id' => $transaction->id,
        ]);
    }

    public function test_deletion_is_rejected_if_transaction_stock_has_already_been_used(): void
    {
        $this->signInAsAdmin();
        [$transaction, $item] = $this->createIncomingTransaction(stock: 3, quantity: 5);

        $this->followingRedirects()
            ->delete(route('incoming-transactions.destroy', $transaction))
            ->assertOk()
            ->assertSee('Transaksi barang masuk tidak dapat dihapus karena stok dari transaksi tersebut sudah digunakan.')
            ->assertSee('toast--error', false);

        $this->assertSame(3, $item->fresh()->stock);
        $this->assertDatabaseHas('incoming_transactions', ['id' => $transaction->id]);
        $this->assertDatabaseHas('incoming_details', [
            'incoming_transaction_id' => $transaction->id,
        ]);
    }

    public function test_deleting_outgoing_transaction_restores_stock_and_removes_details(): void
    {
        $this->signInAsAdmin();
        $item = Item::create([
            'code' => 'OUT-DELETE-001',
            'name' => 'Barang Keluar Uji',
            'category_id' => Category::create(['name' => 'Kategori Keluar'])->id,
            'unit_id' => Unit::create(['name' => 'Unit Keluar'])->id,
            'stock' => 8,
            'minimum_stock' => 1,
        ]);

        $transaction = OutgoingTransaction::create([
            'transaction_number' => 'BK-DELETE-001',
            'date' => now()->toDateString(),
            'department_id' => Department::create(['name' => 'Bidang Uji'])->id,
        ]);
        OutgoingDetail::create([
            'outgoing_transaction_id' => $transaction->id,
            'item_id' => $item->id,
            'quantity' => 3,
        ]);
        $item->decrement('stock', 3);

        $this->get(route('outgoing-transactions.index'))
            ->assertOk()
            ->assertSee(route('outgoing-transactions.destroy', $transaction), false)
            ->assertSee('Hapus transaksi barang keluar', false);

        $this->get(route('reports.outgoing'))
            ->assertOk()
            ->assertSee(route('outgoing-transactions.destroy', $transaction), false)
            ->assertSee('Hapus transaksi barang keluar', false);

        $this->delete(route('outgoing-transactions.destroy', $transaction))
            ->assertRedirect(route('outgoing-transactions.index'))
            ->assertSessionHas(
                'success',
                'Transaksi barang keluar berhasil dihapus dan stok telah dikembalikan.'
            );

        $this->assertSame(8, $item->fresh()->stock);
        $this->assertDatabaseMissing('outgoing_transactions', ['id' => $transaction->id]);
        $this->assertDatabaseMissing('outgoing_details', [
            'outgoing_transaction_id' => $transaction->id,
        ]);
    }

    private function signInAsAdmin(): void
    {
        $this->actingAs(User::create([
            'name' => 'Administrator',
            'email' => 'incoming-delete-admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]));
    }

    /**
     * @return array{IncomingTransaction, Item}
     */
    private function createIncomingTransaction(int $stock, int $quantity): array
    {
        $item = Item::create([
            'code' => 'IN-DELETE-001',
            'name' => 'Barang Uji',
            'category_id' => Category::create(['name' => 'Kategori Uji'])->id,
            'unit_id' => Unit::create(['name' => 'Unit Uji'])->id,
            'stock' => $stock,
            'minimum_stock' => 0,
        ]);

        $transaction = IncomingTransaction::create([
            'transaction_number' => 'BM-DELETE-001',
            'date' => now()->toDateString(),
            'supplier_id' => Supplier::create(['name' => 'Sumber Dana Uji'])->id,
        ]);

        IncomingDetail::create([
            'incoming_transaction_id' => $transaction->id,
            'item_id' => $item->id,
            'quantity' => $quantity,
            'price' => 1000,
        ]);

        return [$transaction, $item];
    }
}
