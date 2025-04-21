package com.example.onclass.z001_QL_SinhVien_CSDL;

import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;
import java.util.List;

public class Z001_QL_SinhVien extends AppCompatActivity {

    private EditText editName, editNgaySinh, editDiaChi;
    private RadioButton btnNam, btnNu;
    private CheckBox checkKinhTe, checkSuPham, checkCNTT;
    private Button btnLuu, btnView;
    private int gioi_tinh = -1;
    private String truong_yeu_thich = "";
    private List<Person> list;

    private SQLiteDatabase database;
    private Adapter adapter;
    private ListView listView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_z001_ql_sinh_vien);

        AnhXa();
        CSDL();
        HienThiDuLieu();

        btnNam.setOnClickListener(view -> gioi_tinh = 1);
        btnNu.setOnClickListener(view -> gioi_tinh = 0);

        btnLuu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String name = editName.getText().toString();
                String ngaySinh = editNgaySinh.getText().toString();
                String diaChi = editDiaChi.getText().toString();
                int gioiTinh = gioi_tinh;
                try {
                    if (checkKinhTe.isChecked()) {
                        truong_yeu_thich += ", ĐH Kinh tế";
                    }
                    if (checkCNTT.isChecked()) {
                        truong_yeu_thich += ", ĐH CNTT";
                    }
                    if (checkSuPham.isChecked()) {
                        truong_yeu_thich += ", ĐH Sư phạm";
                    }
                    if (name.isEmpty() || ngaySinh.isEmpty() || diaChi.isEmpty() || gioi_tinh == -1 || truong_yeu_thich == "") {
                        Toast.makeText(Z001_QL_SinhVien.this, "Vui lòng nhập đầy đủ thông tin!", Toast.LENGTH_SHORT).show();
                    } else {
                        String sql = "insert into info(name,ngaySinh,diaChi, gioiTinh, truongYeuThich)" +
                                " values ('" + editName.getText() + "','" + editNgaySinh.getText() + "','" + editDiaChi.getText() + "','" + gioi_tinh + "','" + truong_yeu_thich + "')";
                        database.execSQL(sql);

                        Cursor cursor = database.rawQuery("select last_insert_rowid()", null);
                        int id = -1;
                        if (cursor.moveToFirst()) {
                            id = cursor.getInt(0);
                        }

                        list.add(new Person(id, name, ngaySinh, diaChi, gioiTinh, truong_yeu_thich));

                        gioi_tinh = -1;
                        editName.setText("");
                        btnNam.setChecked(false);
                        btnNu.setChecked(false);
                        adapter.notifyDataSetChanged();
                        Toast.makeText(Z001_QL_SinhVien.this, "Thêm thông tin thành công!", Toast.LENGTH_SHORT).show();
                    }
                } catch (Exception e) {
                    Toast.makeText(Z001_QL_SinhVien.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        });

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(view.getContext(), Z001_next_intent.class);
                intent.putExtra("person", list.get(i));
                startActivity(intent);
            }
        });
    }

    private void HienThiDuLieu() {
        String sql = "select * from info";
        Cursor cursor = database.rawQuery(sql, null);
        while (cursor.moveToNext()) {
            int id = cursor.getInt(0);
            String name = cursor.getString(1);
            String ngaySinh = cursor.getString(2);
            String diaChi = cursor.getString(3);
            int gioiTinh = cursor.getInt(4);
            String truongYeuThich = cursor.getString(5);

            list.add(new Person(id, name, ngaySinh, diaChi, gioiTinh, truongYeuThich));
            adapter.notifyDataSetChanged();
        }
    }

    public void CSDL() {
        database = openOrCreateDatabase("SinhVien.db", MODE_PRIVATE, null);
        String sql = "create table if not exists info (id INTEGER primary key autoincrement" +
                ", name text, ngaySinh text, diaChi text, gioiTinh int, truongYeuThich text)";
        database.execSQL(sql);
    }

    private void AnhXa() {
        editName = findViewById(R.id.editName);
        editNgaySinh = findViewById(R.id.editNgaySinh);
        editDiaChi = findViewById(R.id.editDiaChi);
        btnNam = findViewById(R.id.btnNam);
        btnNu = findViewById(R.id.btnNu);
        checkKinhTe = findViewById(R.id.checkKinhTe);
        checkSuPham = findViewById(R.id.checkSuPham);
        checkCNTT = findViewById(R.id.checkCNTT);
        btnLuu = findViewById(R.id.btnLuu);
        btnView = findViewById(R.id.btnView);
        listView = findViewById(R.id.listView);

        list = new ArrayList<>();
        adapter = new Adapter(list);
        listView.setAdapter(adapter);
    }
}
