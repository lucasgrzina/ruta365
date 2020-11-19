<div class="table-responsive">
    <table class="table m-b-0" id="ventas-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Sucursal</th>
                <th>Cantidad Dispositivos</th>
                <th class="text-center" v-for="producto in info.productos">(% producto.nombre %)</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.sucursal.nombre %)</td>
                <td>(% item.cantidad_dispositivos %)</td>
                <td class="text-center" v-for="producto in info.productos">
                    (% obtenerCantPorProducto(item.productos,producto) %)
                </td>
                <td class="td-actions">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <button-type type="edit-list" @click="edit(item)"></button-type>
                        <button-type type="remove-list" @click="destroy(item)"></button-type>
                    @endif
                </td>            
            </tr>
        </tbody>
    </table>
</div>