package com.example.p3l.Adapter

import android.content.Context
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import android.widget.Toast
import androidx.cardview.widget.CardView
import androidx.recyclerview.widget.RecyclerView
import com.example.p3l.Model.IzinInstruktur
import com.example.p3l.R
import org.w3c.dom.Text

class IzinInstrukturAdapter(private var permissions: List<IzinInstruktur>, context: Context): RecyclerView.Adapter<IzinInstrukturAdapter.ViewHolder>()
{
    private val context: Context

    init {
        this.context = context
    }
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        val view = inflater.inflate(R.layout.activity_izin_instruktur_adapter, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: IzinInstrukturAdapter.ViewHolder, position: Int) {
        val data = permissions[position]
        holder.tvKeterangan.text = "Keterangan: ${data.KETERANGAN_IZIN}"
        holder.tvTanggalIzin.text = "Tanggal Izin: ${data.TANGGAL_IZIN_INSTRUKTUR}"
        holder.tvMelakukan.text = "Tanggal Melakukan Izin: ${data.TANGGAL_MELAKUKAN_IZIN}"
        holder.tvStatus.text = "${data.STATUS_IZIN} - ${data.TANGGAL_KONFIRMASI}"
        if(holder.tvStatus.text == "null - null") {
            holder.tvStatus.text = "Belum dikonfirmasi"
        }
        holder.cvpermission.setOnClickListener{
            Toast.makeText(context,data.KETERANGAN_IZIN, Toast.LENGTH_SHORT).show()
        }
        holder.tvNamaInstrukturPengganti.text ="Nama Instruktur: ${data.NAMA_INSTRUKTUR_PENGGANTI}"
    }

    override fun getItemCount(): Int {
        return permissions.size
    }

//    fun setPermissionList(permissionss: Array<IzinInstruktur>){
//        this.permissions = permissionss.toList()
//    }

    inner class ViewHolder(view: View) : RecyclerView.ViewHolder(view){
        var tvKeterangan: TextView
        var tvTanggalIzin: TextView
        var tvMelakukan: TextView
        var tvStatus: TextView
        var cvpermission: CardView
        var tvNamaInstrukturPengganti: TextView

        init {
            tvKeterangan = view.findViewById(R.id.text_keterangan)
            tvTanggalIzin = view.findViewById(R.id.text_tanggal_izin)
            tvMelakukan = view.findViewById(R.id.text_tanggal_melakukan_izin)
            tvStatus = view.findViewById(R.id.text_status)
            cvpermission = view.findViewById(R.id.cv_izin)
            tvNamaInstrukturPengganti = view.findViewById(R.id.text_nama)
        }
    }
}