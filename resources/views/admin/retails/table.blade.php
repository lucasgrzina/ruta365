<div class="table-responsive">
    <table class="table m-b-0" id="retails-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Nombre</th>
                <th>Pais</th>
                <th>Logo</th>
                <th>Color Hexa</th>
                <th>Sucursales</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.nombre %)</td>
                <td>(% item.pais ? item.pais.nombre : '--' %)</td>
                <td><img :src="item.logo_url" class="img-responsive" style="max-width: 50px;"></td>
                <td>(% item.color_hexa %)</td>
                <td>
                    <a :href="urlImportarSucursales(item)"><i class="fa fa-circle"></i> Importar</a><br>
                    <a target="_blank" :href="urlListadoSucursales(item)"><i class="fa fa-circle"></i> Listado</a><br>
                    <a :href="urlObjetivos(item)"><i class="fa fa-circle"></i> Objetivos</a><br>
                </td>
                <td class="td-actions">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('ver-'.$data['action_perms']))
                        <button-type type="show-list" @click="show(item)"></button-type>
                    @endif
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <button-type type="edit-list" @click="edit(item)"></button-type>
                        <button-type type="remove-list" @click="destroy(item)"></button-type>
                    @endif
                </td>            
            </tr>
        </tbody>
    </table>
</div>