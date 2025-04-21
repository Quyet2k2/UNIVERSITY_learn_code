package com.example.onclass._9_QL_NhanVien_CSDL;

import android.content.DialogInterface;
import android.database.Cursor;
import android.database.DataSetObserver;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;
import java.util.List;

public class C9_QL_NhanVien_CSDL extends AppCompatActivity {
    private static SQLiteDatabase database;
    private EditText editName, editMaNV;
    private RadioButton btnNu, btnNam;
    private ImageButton btnDelete;
    private Button btnAdd;
    private ListView listView;
    private List<C9_NhanVien> list;
    private C9_Adapter_NhanVien adapterNhanVien;
    private int gioi_tinh = -1;
    private MenuItem btnDeleteAll;

    public static SQLiteDatabase getDatabase() {
        return database;
    }

    public void CSDL() {
        database = openOrCreateDatabase("NhanVien.db", MODE_PRIVATE, null);
        String sql = "create table if not exists info (id INTEGER primary key autoincrement, name text, gioiTinh int, isCheck int)";
        database.execSQL(sql);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c9_ql_nhan_vien_csdl);

        AnhXa();
        CSDL();
        HienThiDuLieu();
        XuLyChuoiNhap(editMaNV);
        XuLyChuoiNhap(editName);

        adapterNhanVien.registerDataSetObserver(new DataSetObserver() {
            @Override
            public void onChanged() {
                btnDeleteAll.setEnabled(list.size() != 0);
            }
        });

        btnNam.setOnClickListener(view -> gioi_tinh = 1);
        btnNu.setOnClickListener(view -> gioi_tinh = 0);
        btnAdd.setOnClickListener(view -> {
            try {
                String name = editMaNV.getText().toString() + "-" + editName.getText().toString();

                if (editMaNV.getText().toString().isEmpty() || editName.getText().toString().isEmpty() || gioi_tinh == -1) {
                    Toast.makeText(this, "Vui lòng nhập đầy đủ thông tin!", Toast.LENGTH_SHORT).show();
                } else {
                    String sql = "insert into info(name, gioiTinh, isCheck) values ('" + name + "','" + gioi_tinh + "','" + 0 + "')";
                    database.execSQL(sql);

                    Cursor cursor = database.rawQuery("select last_insert_rowid()", null);
                    int id = -1;
                    if (cursor.moveToFirst()) {
                        id = cursor.getInt(0);
                    }

                    list.add(new C9_NhanVien(id, name, gioi_tinh, 0));
                    gioi_tinh = -1;
                    editMaNV.setText("");
                    editName.setText("");
                    btnNam.setChecked(false);
                    btnNu.setChecked(false);
                    adapterNhanVien.notifyDataSetChanged();
                    Toast.makeText(this, "Thêm thông tin thành công!", Toast.LENGTH_SHORT).show();
                }
            } catch (Exception e) {
                Toast.makeText(this, e.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                String[] name = list.get(i).getName().split("-");
                editMaNV.setText(name[0]);
                editName.setText(name[1]);
                if (list.get(i).getGioiTinh() == 1) {
                    gioi_tinh = 1;
                    btnNam.setChecked(true);
                } else {
                    gioi_tinh = 0;
                    btnNu.setChecked(true);
                }
            }
        });
        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!database.isOpen()) {
                    Toast.makeText(C9_QL_NhanVien_CSDL.this, "da dong", Toast.LENGTH_SHORT).show();
                    CSDL();
                }
                List<C9_NhanVien> danhSachXoa = new ArrayList<>();
                for (C9_NhanVien nhanVien : list) {
                    if (nhanVien.getCheck() == 1) {
                        danhSachXoa.add(nhanVien);
                        String sql = "delete from info where id = " + "'" + nhanVien.getId() + "'";
                        database.execSQL(sql);
                    }
                }

                list.removeAll(danhSachXoa);
                adapterNhanVien.notifyDataSetChanged();
            }
        });
    }

    private void HienThiDuLieu() {
        String sql = "select * from info";
        Cursor cursor = database.rawQuery(sql, null);
        while (cursor.moveToNext()) {
            int id = cursor.getInt(0);
            String name = cursor.getString(1);
            int gioiTinh = cursor.getInt(2);
            int isCheck = cursor.getInt(3);

            list.add(new C9_NhanVien(id, name, gioiTinh, isCheck));
            adapterNhanVien.notifyDataSetChanged();
        }
    }

    private void AnhXa() {
        editMaNV = findViewById(R.id.editMaNV);
        editName = findViewById(R.id.editName);
        btnNam = findViewById(R.id.btnNam);
        btnNu = findViewById(R.id.btnNu);
        btnAdd = findViewById(R.id.btnAdd);
        btnDelete = findViewById(R.id.btnDelete);
        listView = findViewById(R.id.listView);
        list = new ArrayList<>();
        adapterNhanVien = new C9_Adapter_NhanVien(list);
        listView.setAdapter(adapterNhanVien);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.c9_heading_pop_up_menu, menu);
        btnDeleteAll = menu.findItem(R.id.btnDeleteAllItem);
        btnDeleteAll.setEnabled(list.size() != 0);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == R.id.btnDeleteAllItem) {
            AlertDialog.Builder builder = new AlertDialog.Builder(C9_QL_NhanVien_CSDL.this).setTitle("Xác nhận").setMessage("Bạn có muốn xóa tất cả phần tử không?").setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    String sql = "delete from info ";
                    database.execSQL(sql);
                    list.removeAll(list);
                    adapterNhanVien.notifyDataSetChanged();
                }
            }).setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    dialogInterface.dismiss();
                }
            });
            AlertDialog alertDialog = builder.create();
            alertDialog.show();
        }
        return true;
    }

    private void XuLyChuoiNhap(EditText editText) {
        editText.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                // Không cần xử lý trước khi nhập
            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                // Kiểm tra xem chuỗi có chứa "-" không
                if (charSequence.toString().contains("-")) {
                    Toast.makeText(C9_QL_NhanVien_CSDL.this, "Chuỗi không được phép có chứa ký tự \"-\" !", Toast.LENGTH_SHORT).show();
                    // Nếu có, loại bỏ ký tự "-"
                    editText.setText(charSequence.toString().replace("-", ""));

                    // Di chuyển con trỏ về cuối chuỗi
                    editText.setSelection(editText.getText().length());
                }
            }

            @Override
            public void afterTextChanged(Editable editable) {

            }
        });
    }
}
