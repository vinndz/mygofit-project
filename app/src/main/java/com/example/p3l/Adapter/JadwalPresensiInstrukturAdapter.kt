package com.example.p3l.Adapter

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.cardview.widget.CardView
import androidx.recyclerview.widget.RecyclerView
import com.example.p3l.Activity.JadwalPresensiInstrukturActivity
import com.example.p3l.Activity.PresensiBookingKelasActivity
import com.example.p3l.Model.JadwalInstruktur
import com.example.p3l.R

class JadwalPresensiInstrukturAdapter (private var instructors: List<JadwalInstruktur>, context: Context):
    RecyclerView.Adapter<JadwalPresensiInstrukturAdapter.ViewHolder>() {
    private val context: Context

    init {
        this.context = context
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): JadwalPresensiInstrukturAdapter.ViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        val view = inflater.inflate(R.layout.activity_jadwal_presensi_instruktur_adapter, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: JadwalPresensiInstrukturAdapter.ViewHolder, position: Int) {
        val data = instructors[position]
        val preferences = context.getSharedPreferences("login", Context.MODE_PRIVATE)
        holder.tvKelas.text = data.NAMA_KELAS
        holder.tvInstruktur.text = data.NAMA_INSTRUKTUR
        holder.tvTanggal.text = data.TANGGAL_JADWAL_HARIAN
        holder.tvHari.text = data.HARI_KELAS
        holder.tvKeterangan.text = data.KETERANGAN

        holder.cvSchedule.setOnClickListener {
            if (context is JadwalPresensiInstrukturActivity){
                val intent = Intent(context, PresensiBookingKelasActivity::class.java)
                preferences.edit()
                    .putString("tanggal_jadwal_harian",data.TANGGAL_JADWAL_HARIAN)
                    .apply()
                context.startActivity(intent)
            }
        }
    }

    override fun getItemCount(): Int {
        return instructors.size
    }

    inner class ViewHolder(view: View) : RecyclerView.ViewHolder(view){
        var tvKelas: TextView
        var tvInstruktur: TextView
        var tvKeterangan: TextView
        var tvHari: TextView
        var tvTanggal: TextView
        var cvSchedule: CardView


        init {
            tvKelas = view.findViewById(R.id.text_kelas)
            tvInstruktur = view.findViewById(R.id.text_instruktur)
            tvKeterangan = view.findViewById(R.id.text_keterangan_instruktur)
            tvHari = view.findViewById(R.id.tv_hari_instruktur)
            tvTanggal = view.findViewById(R.id.tv_tanggal_instruktur)
            cvSchedule = view.findViewById(R.id.cv_jadwal_instruktur)
        }

    }
}