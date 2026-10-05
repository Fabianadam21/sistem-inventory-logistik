<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\IncomingDetail;
use App\Models\IncomingTransaction;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MasterDataDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_warehouse_module_is_no_longer_available(): void
    {
        $this->signInAsAdmin();

        $this->get('/warehouses')->assertNotFound();
        $this->assertFalse(Schema::hasTable('warehouses'));
        $this->assertFalse(Schema::hasColumn('items', 'warehouse_id'));
        $this->assertTrue(Schema::hasColumn('items', 'supplier_id'));
    }

    public function test_unused_unit_can_be_deleted(): void
    {
        $this->signInAsAdmin();
        $unit = Unit::create(['name' => 'Unit A']);

        $response = $this->delete(route('units.destroy', $unit));

        $response->assertRedirect(route('units.index'))
            ->assertSessionHas('success', 'Satuan berhasil dihapus.');
        $this->assertDatabaseMissing('units', ['id' => $unit->id]);
    }

    public function test_unit_in_use_cannot_be_deleted(): void
    {
        $this->signInAsAdmin();
        $unit = Unit::create(['name' => 'Unit A']);
        $this->createItemIn($unit);

        $response = $this->delete(route('units.destroy', $unit));

        $response->assertRedirect(route('units.index'))
            ->assertSessionHas('error', 'Satuan tidak dapat dihapus karena masih digunakan oleh data barang.');
        $this->assertDatabaseHas('units', ['id' => $unit->id]);
    }

    public function test_item_uses_source_fund_and_displays_unit_price(): void
    {
        $this->signInAsAdmin();
        $category = Category::create(['name' => 'Bahan Pangan']);
        $unit = Unit::create(['name' => 'Kilogram']);
        $supplier = Supplier::create(['name' => 'APBD']);

        $this->get(route('items.create'))
            ->assertOk()
            ->assertSee('Sumber Dana')
            ->assertSee('Harga');

        $this->post(route('items.store'), [
            'code' => 'ITEM-001',
            'name' => 'Beras',
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'supplier_id' => $supplier->id,
            'stock' => 18,
            'minimum_stock' => 2,
            'price' => 25000,
        ])->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', [
            'code' => 'ITEM-001',
            'supplier_id' => $supplier->id,
            'price' => '25000.00',
        ]);

        $this->get(route('items.index'))
            ->assertOk()
            ->assertSee('Sumber Dana')
            ->assertSee('APBD')
            ->assertSee('Rp 25.000');

        $this->get(route('reports.stock'))
            ->assertOk()
            ->assertSee('APBD')
            ->assertSee('Rp 25.000');
    }

    public function test_stock_report_can_delete_an_item_without_transaction_history(): void
    {
        $this->signInAsAdmin();
        $item = $this->createItemIn(Unit::create(['name' => 'Unit Uji']));

        $this->get(route('reports.stock'))
            ->assertOk()
            ->assertSee(route('items.destroy', $item), false)
            ->assertSee('Hapus data barang', false);

        $this->delete(route('items.destroy', $item))
            ->assertRedirect(route('items.index'))
            ->assertSessionHas('success', 'Data barang berhasil dihapus.');

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    public function test_item_used_in_transactions_cannot_be_deleted(): void
    {
        $this->signInAsAdmin();
        $item = $this->createItemIn(Unit::create(['name' => 'Unit Uji']));
        $transaction = IncomingTransaction::create([
            'transaction_number' => 'BM-ITEM-001',
            'date' => now()->toDateString(),
            'supplier_id' => Supplier::create(['name' => 'Sumber Dana Uji'])->id,
        ]);
        IncomingDetail::create([
            'incoming_transaction_id' => $transaction->id,
            'item_id' => $item->id,
            'quantity' => 1,
            'price' => 1000,
        ]);

        $this->delete(route('items.destroy', $item))
            ->assertRedirect(route('items.index'))
            ->assertSessionHas('error', 'Barang tidak dapat dihapus karena sudah digunakan dalam transaksi.');

        $this->assertDatabaseHas('items', ['id' => $item->id]);
    }

    public function test_dashboard_renders_skeleton_and_bar_chart(): void
    {
        $this->signInAsAdmin();

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Ringkasan Inventory')
            ->assertSee(asset('images/logo-pemkot.png'))
            ->assertSee('page-skeleton', false)
            ->assertSee("type: 'bar'", false);
    }

    private function signInAsAdmin(): void
    {
        $this->actingAs(User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]));
    }

    private function createItemIn(Unit $unit): Item
    {
        return Item::create([
            'code' => 'TEST-001',
            'name' => 'Barang Uji',
            'category_id' => Category::create(['name' => 'Kategori Uji'])->id,
            'unit_id' => $unit->id,
        ]);
    }
}
