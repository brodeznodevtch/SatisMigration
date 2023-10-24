<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = 'permissions';


    protected $fillable = ['name', 'description', 'guard_name', 'module_id'];

    public function module()
    {
        return $this->belongsTo(\App\Models\Module::class);
    }

    public static function checkPermissions()
    {
        $permissions = [
            'entries',
            'entries.create',
            'entries.view',
            'entries.update',
            'entries.delete',
            'backup',
            'backup.create',
            'backup.delete',
            'barcode_settings.access',
            'brand.view',
            'brand.create',
            'brand.update',
            'brand.delete',
            'business_settings.access',
            'location.view',
            'location.create',
            'location.update',
            'business_type.view',
            'business_type.update',
            'business_type.delete',
            'business_type.create',
            'cashier.view',
            'cashier.create',
            'cashier.update',
            'cashier.delete',
            'catalogue',
            'category.view',
            'category.create',
            'category.update',
            'category.delete',
            'claim.view',
            'claim.create',
            'claim.update',
            'claim.delete',
            'claim_type.view',
            'claim_type.create',
            'claim_type.update',
            'claim_type.delete',
            'supplier.view',
            'customer.view',
            'supplier.create',
            'customer.create',
            'supplier.update',
            'customer.update',
            'supplier.delete',
            'customer.delete',
            'cdocs.view',
            'cdocs.create',
            'cdocs.reception',
            'cdocs.custodian',
            'cdocs.update',
            'cdocs.delete',
            'crm-contactmode.view',
            'crm-contactmode.create',
            'crm-contactmode.update',
            'crm-contactmode.delete',
            'crm-contactreason.view',
            'crm-contactreason.create',
            'crm-contactreason.update',
            'crm-contactreason.delete',
            'crm-oportunities.view',
            'crm-oportunities.create',
            'crm-oportunities.update',
            'crm-oportunities.delete',
            'customer_group.view',
            'customer_group.create',
            'customer_group.update',
            'customer_group.delete',
            'portfolios.view',
            'portfolios.create',
            'portfolios.update',
            'portfolios.delete',
            'diagnostic.view',
            'diagnostic.create',
            'diagnostic.update',
            'diagnostic.delete',
            'correlatives.view',
            'correlatives.create',
            'correlatives.update',
            'correlatives.delete',
            'document_type.view',
            'document_type.create',
            'document_type.update',
            'document_type.delete',
            'expense_category.access',
            'expense_category.create',
            'expense_category.update',
            'expense_category.delete',
            'expense.access',
            'expense.create',
            'expense.update',
            'expense.delete',
            'follow_customer.create',
            'follow_customer.view',
            'follow_customer.update',
            'follow_customer.delete',
            'follow_oportunities.view',
            'follow_oportunities.create',
            'follow_oportunities.update',
            'follow_oportunities.delete',
            'dashboard.data',
            'purchase.view',
            'sell.view',
            'product.opening_stock',
            'product.create',
            'invoice_settings.access',
            'kardex.view',
            'kardex.register',
            'credit.view',
            'credit.update',
            'credit.delete',
            // 'employees.view',
            // 'employees.create',
            // 'employees.update',
            // 'employees.delete',
            'positions.view',
            'positions.create',
            'positions.update',
            'positions.delete',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'material_type.view',
            'material_type.create',
            'material_type.update',
            'material_type.delete',
            'module.view',
            'module.create',
            'module.update',
            'module.delete',
            'movement_type.view',
            'movement_type.create',
            'movement_type.update',
            'movement_type.delete',
            'send_notification',
            'product.update',
            'oportunities.view',
            'oportunities.create',
            'oportunities.update',
            'oportunities.delete',
            'order.view',
            'order.create',
            'order.update',
            'order.delete',
            'payment_term.view',
            'payment_term.create',
            'payment_term.delete',
            'payment_term.update',
            'permission.view',
            'permission.create',
            'permission.update',
            'permission.delete',
            'pos.view',
            'pos.create',
            'pos.update',
            'pos.delete',
            'pos.cancel',
            'pos.activate',
            'printer.update',
            'printer.delete',
            'product.view',
            'product.edit_price',
            'product.delete',
            'purchase.create',
            'purchase.update',
            'purchase.delete',
            'quotes.view',
            'quotes.create',
            'quotes.update',
            'quotes.delete',
            'profit_loss_report.view',
            'purchase_n_sell_report.view',
            'contacts_report.view',
            'stock_report.view',
            'access_default_selling_price',
            'product_sell_report.view',
            'tax_report.view',
            'trending_product_report.view',
            'expense_report.view',
            'stock_adjustment_report.view',
            'register_report.view',
            'sales_representative.view',
            'stock_expiry_report.view',
            'stock_expiry_report.update',
            'customer_group_report.view',
            'product_purchase_report.view',
            'lot_report.view',
            'purchase_payment_report.view',
            'sell_payment_report.view',
            'table_report.view',
            'service_staff_report.view',
            'product_sell_grouped_report.view',
            'sell_n_adjustment_report.view',
            'cost_of_sale_detail_report.view',
            'auxiliars',
            'ledgers',
            'balances',
            'iva_book.book_final_consumer',
            'iva_book.book_taxpayer',
            'iva_book.purchases_book',
            'cash_register_report.view',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'sales_commission_agent.view',
            'sales_commission_agent.create',
            'sales_commission_agent.update',
            'sales_commission_agent.delete',
            'sell.create',
            'direct_sell.access',
            'sell.update',
            'sell.delete',
            'sell.draft',
            'sell.quotation',
            'selling_price_group.view',
            'selling_price_group.create',
            'selling_price_group.update',
            'selling_price_group.delete',
            'sell.annul',
            'claim_status.create',
            'claim_status.update',
            'claim_status.delete',
            'claim_status.view',
            'stock_adjustment.view',
            'stock_adjustment.create',
            'stock_adjustment.delete',
            'stock_transfer.view',
            'stock_transfer.create',
            'stock_transfer.delete',
            'sdocs.view',
            'sdocs.create',
            'sdocs.update',
            'sdocs.delete',
            'tax_group.view',
            'tax_group.create',
            'tax_group.edit',
            'tax_group.delete',
            'tax_rate.view',
            'tax_rate.create',
            'tax_rate.update',
            'tax_rate.delete',
            'purchase.payments',
            'sell.payments',
            'unit.view',
            'unit.create',
            'unit.update',
            'unit.delete',
            'warehouse.view',
            'warehouse.create',
            'warehouse.update',
            'warehouse.delete',
            'catalogue.import',
            'banks',
            'iva_book.access',
            'crm.view',
            'crm.dashboard',
            'claim.access',
            'quotes.access',
            'credit.access',
            'oportunities.access',
            'crm_settings.view',
            'sales_settings.access',
            'cxc.access',
            'cxc.sdocs',
            'portfolios.access',
            'report.kardex',
            'label.view',
            'crud_all_bookings',
            'crud_own_bookings',
            'account.access',
            'product.view_cost',
            'quotes.add_not_stock',
            'restaurant.create',
            'restaurant.view',
            'edit_product_price_from_sale_screen',
            'edit_product_discount_from_sale_screen',
            'transaction_payment.create',
            'transaction_payment.view',
        ];

        $permissions_not_exist = [];

        foreach ($permissions as $item) {
            $permission = Permission::where('name', $item)->first();

            if (empty($permission)) {
                array_push($permissions_not_exist, $item);
            }
        }

        return $permissions_not_exist;
    }

    public static function registerPermissions()
    {
        $permissions = [
            ['entries.create', 'Crear partidas contables', 'Contabilidad'],
            ['entries.view', 'Ver partidas contables', 'Contabilidad'],
            ['entries.update', 'Actualizar partidas contables', 'Contabilidad'],
            ['entries.delete', 'Eliminar partidas contables', 'Contabilidad'],
            ['backup', 'Respaldos', 'Respaldos'],
            ['backup.create', 'Crear respaldos', 'Respaldos'],
            ['backup.delete', 'Eliminar respaldos', 'Respaldos'],
            ['location.view', 'Ver sucursales', 'Sucursales'],
            ['location.create', 'Crear sucursales', 'Sucursales'],
            ['location.update', 'Actualizar sucursales', 'Sucursales'],
            ['business_type.view', 'Ver tipos de empresas', 'Tipos de empresas'],
            ['business_type.update', 'Actualizar tipos de empresas', 'Tipos de empresas'],
            ['business_type.delete', 'Eliminar tipos de empresas', 'Tipos de empresas'],
            ['business_type.create', 'Crear tipos de empresas', 'Tipos de empresas'],
            ['cashier.view', 'Ver cajas', 'Cajas'],
            ['cashier.create', 'Crear cajas', 'Cajas'],
            ['cashier.update', 'Actualizar cajas', 'Cajas'],
            ['cashier.delete', 'Eliminar cajas', 'Cajas'],
            ['claim.view', 'Ver reclamos', 'Reclamos'],
            ['claim.create', 'Crear reclamos', 'Reclamos'],
            ['claim.update', 'Actualizar reclamos', 'Reclamos'],
            ['claim.delete', 'Eliminar reclamos', 'Reclamos'],
            ['claim_type.view', 'Ver tipos de reclamos', 'Tipos de reclamos'],
            ['claim_type.create', 'Crear tipos de reclamos', 'Tipos de reclamos'],
            ['claim_type.update', 'Actualizar tipos de reclamos', 'Tipos de reclamos'],
            ['claim_type.delete', 'Eliminar tipos de reclamos', 'Tipos de reclamos'],
            ['cdocs.view', 'Ver documentos de crédito', 'Documentos de crédito'],
            ['cdocs.create', 'Crear documentos de crédito', 'Documentos de crédito'],
            ['cdocs.reception', 'Recepción de documentos de crédito', 'Documentos de crédito'],
            ['cdocs.custodian', 'Custodia de documentos de crédito', 'Documentos de crédito'],
            ['cdocs.update', 'Actualizar documentos de crédito', 'Documentos de crédito'],
            ['cdocs.delete', 'Eliminar documentos de crédito', 'Documentos de crédito'],
            ['crm-contactmode.view', 'Ver medios de contacto', 'Medios de contacto'],
            ['crm-contactmode.create', 'Crear medios de contacto', 'Medios de contacto'],
            ['crm-contactmode.update', 'Actualizar medios de contacto', 'Medios de contacto'],
            ['crm-contactmode.delete', 'Eliminar medios de contacto', 'Medios de contacto'],
            ['crm-contactreason.view', 'Ver motivos de contacto', 'Motivos de contacto'],
            ['crm-contactreason.create', 'Crear motivos de contacto', 'Motivos de contacto'],
            ['crm-contactreason.update', 'Actualizar motivos de contacto', 'Motivos de contacto'],
            ['crm-contactreason.delete', 'Eliminar motivos de contacto', 'Motivos de contacto'],
            ['crm-oportunities.view', 'Ver oportunidades', 'Oportunidades'],
            ['crm-oportunities.create', 'Crear oportunidades', 'Oportunidades'],
            ['crm-oportunities.update', 'Actualizar oportunidades', 'Oportunidades'],
            ['crm-oportunities.delete', 'Eliminar oportunidades', 'Oportunidades'],
            ['customer_group.view', 'Ver grupos de clientes', 'Grupos de clientes'],
            ['customer_group.create', 'Ver grupos de clientes', 'Grupos de clientes'],
            ['customer_group.update', 'Ver grupos de clientes', 'Grupos de clientes'],
            ['customer_group.delete', 'Ver grupos de clientes', 'Grupos de clientes'],
            ['portfolios.view', 'Ver carteras de clientes', 'Carteras de clientes'],
            ['portfolios.create', 'Crear carteras de clientes', 'Carteras de clientes'],
            ['portfolios.update', 'Actualizar carteras de clientes', 'Carteras de clientes'],
            ['portfolios.delete', 'Eliminar carteras de clientes', 'Carteras de clientes'],
            ['diagnostic.view', 'Ver diagnósticos', 'Diagnósticos'],
            ['diagnostic.create', 'Crear diagnósticos', 'Diagnósticos'],
            ['diagnostic.update', 'Actualizar diagnósticos', 'Diagnósticos'],
            ['diagnostic.delete', 'Eliminar diagnósticos', 'Diagnósticos'],
            ['correlatives.view', 'Ver correlativos', 'Correlativos'],
            ['correlatives.create', 'Crear correlativos', 'Correlativos'],
            ['correlatives.update', 'Actualizar correlativos', 'Correlativos'],
            ['correlatives.delete', 'Eliminar correlativos', 'Correlativos'],
            ['document_type.view', 'Ver tipos de documentos', 'Tipos de documentos'],
            ['document_type.create', 'Crear tipos de documentos', 'Tipos de documentos'],
            ['document_type.update', 'Actualizar tipos de documentos', 'Tipos de documentos'],
            ['document_type.delete', 'Eliminar tipos de documentos', 'Tipos de documentos'],
            ['expense_category.access', 'Ver a tipos de gastos', 'Tipos de gastos'],
            ['expense_category.create', 'Crear a tipos de gastos', 'Tipos de gastos'],
            ['expense_category.update', 'Actualizar a tipos de gastos', 'Tipos de gastos'],
            ['expense_category.delete', 'Eliminar a tipos de gastos', 'Tipos de gastos'],
            ['expense.create', 'Crear gastos', 'Gastos'],
            ['expense.update', 'Actualizar gastos', 'Gastos'],
            ['expense.delete', 'Eliminar gastos', 'Gastos'],
            ['follow_customer.create', 'Crear seguimientos de clientes', 'Seguimientos de clientes'],
            ['follow_customer.view', 'Ver seguimientos de clientes', 'Seguimientos de clientes'],
            ['follow_customer.update', 'Actualizar seguimientos de clientes', 'Seguimientos de clientes'],
            ['follow_customer.delete', 'Eliminar seguimientos de clientes', 'Seguimientos de clientes'],
            ['follow_oportunities.view', 'Ver seguimientos de clientes', 'Seguimientos de oportunidades'],
            ['follow_oportunities.create', 'Crear seguimientos de clientes', 'Seguimientos de oportunidades'],
            ['follow_oportunities.update', 'Actualizar seguimientos de clientes', 'Seguimientos de oportunidades'],
            ['follow_oportunities.delete', 'Eliminar seguimientos de clientes', 'Seguimientos de oportunidades'],
            ['kardex.view', 'Ver kardex', 'Kardex'],
            ['kardex.register', 'Generar kardex', 'Kardex'],
            ['credit.view', 'Ver créditos', 'Créditos'],
            ['credit.update', 'Actualizar créditos', 'Créditos'],
            ['credit.delete', 'Eliminar créditos', 'Créditos'],
            ['material_type.view', 'Ver tipos de materiales', 'Tipos de materiales'],
            ['material_type.create', 'Crear tipos de materiales', 'Tipos de materiales'],
            ['material_type.update', 'Actualizar tipos de materiales', 'Tipos de materiales'],
            ['material_type.delete', 'Eliminar tipos de materiales', 'Tipos de materiales'],
            ['module.view', 'Ver módulos', 'Módulos'],
            ['module.create', 'Crear módulos', 'Módulos'],
            ['module.update', 'Actualizar módulos', 'Módulos'],
            ['module.delete', 'Eliminar módulos', 'Módulos'],
            ['movement_type.view', 'Ver tipos de movimientos', 'Tipos de movimientos'],
            ['movement_type.create', 'Crear tipos de movimientos', 'Tipos de movimientos'],
            ['movement_type.update', 'Actualizar tipos de movimientos', 'Tipos de movimientos'],
            ['movement_type.delete', 'Eliminar tipos de movimientos', 'Tipos de movimientos'],
            ['send_notification', 'Enviar notificaciones', 'Notificaciones'],
            ['payment_term.view', 'Ver términos de pago', 'Términos de pago'],
            ['payment_term.create', 'Crear términos de pago', 'Términos de pago'],
            ['payment_term.delete', 'Eliminar términos de pago', 'Términos de pago'],
            ['payment_term.update', 'Actualizar términos de pago', 'Términos de pago'],
            ['permission.view', 'Ver permisos', 'Permisos'],
            ['permission.create', 'Crear permisos', 'Permisos'],
            ['permission.update', 'Actualizar permisos', 'Permisos'],
            ['permission.delete', 'Eliminar permisos', 'Permisos'],
            ['pos.view', 'Ver Pos', 'Pos'],
            ['pos.create', 'Crear Pos', 'Pos'],
            ['pos.update', 'Actualizar Pos', 'Pos'],
            ['pos.delete', 'Eliminar Pos', 'Pos'],
            ['pos.cancel', 'Cancelar Pos', 'Pos'],
            ['pos.activate', 'Activar Pos', 'Pos'],
            ['printer.update', 'Actualizar impresoras', 'Impresoras'],
            ['printer.delete', 'Eliminar impresoras', 'Impresoras'],
            ['product_sell_report.view', 'Ver informe de venta del producto', 'Reportes'],
            ['stock_adjustment_report.view', 'Ver informe de ajuste de stock', 'Reportes'],
            ['stock_expiry_report.view', 'Ver informe de vencimiento de existencias', 'Reportes'],
            ['stock_expiry_report.update', 'Actualizar informe de vencimiento de existencias', 'Reportes'],
            ['customer_group_report.view', 'Ver informe de compra del producto', 'Reportes'],
            ['product_purchase_report.view', 'Ver informe de compra del producto', 'Reportes'],
            ['lot_report.view', 'Ver informe de lote', 'Reportes'],
            ['purchase_payment_report.view', 'Ver informe de pago de compra', 'Reportes'],
            ['sell_payment_report.view', 'Ver informe de pago de ventas', 'Reportes'],
            ['table_report.view', 'Ver informe de tabla', 'Reportes'],
            ['service_staff_report.view', 'Ver informe del personal de servicio', 'Reportes'],
            ['product_sell_grouped_report.view', 'Ver informe de ventas del producto', 'Reportes'],
            //['sell_n_adjustment_report.view', 'Ver reporte de consumo', 'Reportes'],
            ['iva_book.book_final_consumer', 'Ver libro de ventas a consumidor final', 'Contabilidad'],
            ['iva_book.book_taxpayer', 'Ver libro de ventas a contribuyente', 'Contabilidad'],
            ['iva_book.purchases_book', 'Ver libro de compras', 'Contabilidad'],
            //['cash_register_report.view', 'Ver informe de cierres de caja', 'Reportes'],
            ['sales_commission_agent.view', 'Ver comisión de vendedores', 'Empleados'],
            ['sales_commission_agent.create', 'Crear comisión de vendedores', 'Empleados'],
            ['sales_commission_agent.update', 'Actualizar comisión de vendedores', 'Empleados'],
            ['sales_commission_agent.delete', 'Eliminar comisión de vendedores', 'Empleados'],
            ['sell.draft', 'Borrar ventas', 'Ventas'],
            ['sell.quotation', 'Cotizar', 'Ventas'],
            ['selling_price_group.view', 'Ver grupos de precios de venta', 'Grupos de precios de venta'],
            ['selling_price_group.create', 'Crear grupos de precios de venta', 'Grupos de precios de venta'],
            ['selling_price_group.update', 'Actualizar grupos de precios de venta', 'Grupos de precios de venta'],
            ['selling_price_group.delete', 'Eliminar grupos de precios de venta', 'Grupos de precios de venta'],
            ['sell.annul', 'Anular ventas', 'Ventas'],
            ['claim_status.create', 'Crear estados de reclamos', 'Estados de reclamos'],
            ['claim_status.update', 'Actualizar estados de reclamos', 'Estados de reclamos'],
            ['claim_status.delete', 'Eliminar estados de reclamos', 'Estados de reclamos'],
            ['claim_status.view', 'Ver estados de reclamos', 'Estados de reclamos'],
            ['stock_adjustment.view', 'Ver ajustes de stock', 'Ajustes de stock'],
            ['stock_adjustment.create', 'Crear ajustes de stock', 'Ajustes de stock'],
            ['stock_adjustment.delete', 'Eliminar ajustes de stock', 'Ajustes de stock'],
            ['stock_transfer.view', 'Ver transferencias de stock', 'Transferencias de stock'],
            ['stock_transfer.create', 'Crear transferencias de stock', 'Transferencias de stock'],
            ['stock_transfer.delete', 'Eliminar transferencias de stock', 'Transferencias de stock'],
            ['sdocs.view', 'Ver documentos de soporte', 'Documentos de soporte'],
            ['sdocs.create', 'Crear documentos de soporte', 'Documentos de soporte'],
            ['sdocs.update', 'Actualizar documentos de soporte', 'Documentos de soporte'],
            ['sdocs.delete', 'Eliminar documentos de soporte', 'Documentos de soporte'],
            ['tax_group.view', 'Ver grupos de impuestos', 'Grupos de impuestos'],
            ['tax_group.create', 'Crear grupos de impuestos', 'Grupos de impuestos'],
            ['tax_group.edit', 'Actualizar grupos de impuestos', 'Grupos de impuestos'],
            ['tax_group.delete', 'Eliminar grupos de impuestos', 'Grupos de impuestos'],
            ['warehouse.view', 'Ver bodegas', 'Bodegas'],
            ['warehouse.create', 'Crear bodegas', 'Bodegas'],
            ['warehouse.update', 'Actualizar bodegas', 'Bodegas'],
            ['warehouse.delete', 'Eliminar bodegas', 'Bodegas'],
            ['catalogue.import', 'Importar catálogo', 'Contabilidad'],
            ['banks', 'Gestionar bancos', 'Bancos'],
            ['iva_book.access', 'Acceso a los libros de IVA', 'Reportes'],
            ['crm.view', 'Ver CRM', 'CRM'],
            ['crm.dashboard', 'Ver estadísticas', 'CRM'],
            ['claim.access', 'Acceso a reclamos', 'Reclamos'],
            ['credit.access', 'Acceso a créditos', 'Créditos'],
            ['crm_settings.view', 'Ver configuraciones de CRM', 'CRM'],
            ['sales_settings.access', 'Configuración de las ventas', 'Configuraciones'],
            ['cxc.access', 'Acceso a cuentas por cobrar', 'Cuentas por cobrar'],
            ['cxc.sdocs', 'Documentos de soporte de cuentas por cobrar', 'Cuentas por cobrar'],
            ['portfolios.access', 'Acceso a carteras de clientes', 'Carteras de clientes'],
            ['report.kardex', 'Ver reporte de kardex', 'Reportes'],
            ['label.view', 'Ver etiquetas', 'Reportes'],
            ['account.access', 'Acceso a cuentas', 'Contabilidad'],
            ['restaurant.create', 'Crear restaurantes', 'Restaurantes'],
            ['restaurant.view', 'Ver restaurantes', 'Restaurantes'],
            ['transaction_payment.create', 'Crear pagos', 'Pagos'],
            ['transaction_payment.view', 'Ver pagos', 'Pagos'],
            ['binacle.view', 'Ver bitácora', 'Bitácora'],
            ['alert.view', 'Ver aviso', 'Avisos'],
            ['alert.create', 'Crear avisos', 'Avisos'],
            ['alert.edit', 'Actualizar avisos', 'Avisos'],
            ['alert.delete', 'Eliminar avisos', 'Avisos'],
            ['payment_commitment.view', 'Ver quedan', 'Quedan'],
            ['payment_commitment.create', 'Crear quedan', 'Quedan'],
            ['payment_commitment.edit', 'Actualizar quedan', 'Quedan'],
            ['payment_commitment.delete', 'Eliminar quedan', 'Quedan'],
            ['payment_commitment.annul', 'Anular quedan', 'Quedan'],
            ['debts_to_pay.view', 'Ver informe de cuentas por pagar', 'Compras'],
            ['suggested_purchase.view', 'Ver reporte del sugerido de compra', 'Compras'],
            ['import_expense.view', 'Ver gastos de importación', 'Gastos de importación'],
            ['import_expense.create', 'Crear gastos de importación', 'Gastos de importación'],
            ['import_expense.update', 'Actualizar gastos de importación', 'Gastos de importación'],
            ['import_expense.delete', 'Eliminar gastos de importación', 'Gastos de importación'],
            ['sales_by_seller_report.view', 'Ver ventas por vendedor', 'Reportes'],
            ['connect_report.view', 'Ver reporte Connect', 'Reportes'],
            ['sale_cost_product_report.view', 'Ver reporte de CV por producto', 'Reportes'],
            ['price_lists_report.view', 'Ver reporte de listas de precios', 'Reportes'],
            ['connect_report.view', 'Ver reporte Connect', 'Reportes'],
            ['sale_cost_product_report.view', 'Ver reporte de CV por producto', 'Reportes'],
        ];

        $modules = [
            ['Respaldos', 'Gestionar respaldos'],
            ['Cajas', 'Gestionar cajas'],
            ['Reclamos', 'Gestionar reclamos'],
            ['Tipos de reclamos', 'Gestionar tipos de reclamos'],
            ['Documentos de crédito', 'Gestionar documentos de crédito'],
            ['Medios de contacto', 'Gestionar medios de contacto'],
            ['Motivos de contacto', 'Gestionar motivos de contacto'],
            ['Oportunidades', 'Gestionar oportunidades'],
            ['Grupos de clientes', 'Gestionar grupos de clientes'],
            ['Carteras de clientes', 'Gestionar carteras de clientes'],
            ['Diagnósticos', 'Gestionar diagnósticos'],
            ['Correlativos', 'Gestionar correlativos'],
            ['Tipos de documentos', 'Gestionar tipos de documentos'],
            ['Tipos de gastos', 'Gestionar tipos de gastos'],
            ['Gastos', 'Gestionar gastos'],
            ['Seguimientos de clientes', 'Gestionar seguimientos de clientes'],
            ['Seguimientos de oportunidades', 'Gestionar seguimientos de oportunidades'],
            ['Créditos', 'Gestionar créditos'],
            ['Tipos de materiales', 'Gestionar tipos de materiales'],
            ['Módulos', 'Gestionar módulos'],
            ['Notificaciones', 'Gestionar notificaciones'],
            ['Términos de pago', 'Gestionar términos de pago'],
            ['Permisos', 'Gestionar permisos'],
            ['Pos', 'Gestionar Pos'],
            ['Impresoras', 'Gestionar impresoras'],
            ['Grupos de precios de venta', 'Gestionar grupos de precios de venta'],
            ['Estados de reclamos', 'Gestionar estados de reclamos'],
            ['Ajustes de stock', 'Gestionar ajustes de stock'],
            ['Documentos de soporte', 'Gestionar documentos de soporte'],
            ['Grupos de impuestos', 'Gestionar grupos de impuestos'],
            ['Bodegas', 'Gestionar bodegas'],
            ['Bancos', 'Gestionar bancos'],
            ['Cuentas por cobrar', 'Gestionar cuentas por cobrar'],
            ['Etiquetas', 'Gestionar etiquetas'],
            ['Restaurantes', 'Gestionar restaurantes'],
            ['Pagos', 'Gestionar pagos'],
            ['Tipos de empresas', 'Gestionar tipos de empresas'],
            ['Transferencias de stock', 'Gestionar transferencias de stock'],
            ['Restaurante', 'Gestionar restaurantes'],
            ['Tipos de movimientos', 'Gestionar tipos de movimientos'],
            ['Kardex', 'Acceso al kardex'],
            ['Bitácora', 'Acceso a la bitácora'],
            ['Avisos', 'Gestionar avisos'],
            ['Quedan', 'Gestionar quedan'],
            ['Gastos de importación', 'Gestionar gastos de importación'],
        ];

        try {
            \Log::info('START');

            DB::beginTransaction();

            foreach ($modules as $item) {
                $validate = Module::where('name', $item[0])->first();

                if (empty($validate)) {
                    $module = Module::create([
                        'name' => $item[0],
                        'description' => $item[1],
                        'status' => 1,
                    ]);

                    \Log::info('Module: '.$module->name);
                }
            }

            foreach ($permissions as $item) {
                $module = Module::where('name', $item[2])->first();

                $validate = Permission::where('name', $item[0])->first();

                if (empty($validate)) {
                    $permission = Permission::create([
                        'name' => $item[0],
                        'description' => $item[1],
                        'module_id' => $module->id,
                    ]);

                    \Log::info('Permission: '.$permission->name);
                }
            }

            DB::commit();

            \Log::info('END');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());
        }
    }
}