package com.example.onclass._8_DanhBa_CSDL;

import android.content.ContentValues;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.onclass.R;

import java.util.ArrayList;
import java.util.List;

public class C8_DanhBa_CSDL extends AppCompatActivity implements EditWithPopupMenu {
    private EditText editName, editNumber;
    private List<C8_DanhBa> list;
    private C8_DanhBa_Adapter c8DanhBaAdapter;
    private ListView contactListView;
    private SQLiteDatabase database;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_c8_danh_ba_csdl);
        try {
            AnhXa();
            CSDL();
            HienThiDuLieu();

            contactListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                    Intent intent = new Intent(view.getContext(), C8_DanhBa_next_CSDL.class);
                    intent.putExtra("person", list.get(i));
                    startActivity(intent);
                }
            });
            contactListView.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
                @Override
                public boolean onItemLongClick(AdapterView<?> adapterView, View view, int i, long l) {
                    editName.setText(list.get(i).getName().trim());
                    editNumber.setText(Integer.toString(list.get(i).getNumber()).trim());
                    return true;
                }
            });
        } catch (Exception e) {
            Loi(e, "onCreate");
        }
    }

    private void HienThiDuLieu() {
        String sql = "select * from info";
        Cursor cursor = database.rawQuery(sql, null);
        while (cursor.moveToNext()) {
            int id = cursor.getInt(0);
            String name = cursor.getString(1);
            String phone = cursor.getString(2);
            list.add(new C8_DanhBa(id, name, Integer.parseInt(phone)));
            c8DanhBaAdapter.notifyDataSetChanged();
        }

    }

    private void CSDL() {
        database = openOrCreateDatabase("danhba.db", MODE_PRIVATE, null);
        String sql = "create table if not exists info (id INTEGER primary key autoincrement, name text, phone text)";
        database.execSQL(sql);
    }


    private void AnhXa() {
        editName = findViewById(R.id.editName);
        editNumber = findViewById(R.id.editNumber);
        contactListView = findViewById(R.id.contactListView);
        list = new ArrayList<>();
        c8DanhBaAdapter = new C8_DanhBa_Adapter(list, this);
        contactListView.setAdapter(c8DanhBaAdapter);
    }

    private C8_DanhBa getContactInformation() {
        if (editName.getText().toString().isEmpty() || editNumber.getText().toString().isEmpty()) {
            Toast.makeText(this, "Vui lòng nhập đầy đủ thông tin", Toast.LENGTH_SHORT).show();
            return null;
        } else
            return new C8_DanhBa(editName.getText().toString().trim(), Integer.parseInt(editNumber.getText().toString().trim()));
    }

    @Override
    public void editPerson(int i) {
        if (getContactInformation() != null) {
            try {
                // Xác định bảng và giá trị cần cập nhật
                String tableName = "info"; // Thay "info" bằng tên bảng của bạn
                ContentValues values = new ContentValues();
                values.put("name", getContactInformation().getName()); // Tên cột và giá trị mới
                values.put("phone", getContactInformation().getNumber()); // Tên cột và giá trị mới

                // Xác định điều kiện cập nhật
                String whereClause = "id = ?"; // Sử dụng tên cột ID của bạn
                String[] whereArgs = {String.valueOf(list.get(i).getId())}; // Giá trị của ID cần cập nhật

                // Thực hiện lệnh cập nhật
                int rowsAffected = database.update(tableName, values, whereClause, whereArgs);

                if (rowsAffected > 0) {
                    // Nếu có ít nhất một dòng được cập nhật thành công, thông báo thành công
                    Toast.makeText(this, "Thông tin đã được cập nhật thành công", Toast.LENGTH_SHORT).show();
                } else {
                    // Nếu không có dòng nào được cập nhật, thông báo không tìm thấy ID
                    Toast.makeText(this, "Không tìm thấy ID để cập nhật", Toast.LENGTH_SHORT).show();
                }
            } catch (Exception e) {
                // Xử lý lỗi nếu có
                Loi(e, "editPersonInDatabase");
                System.out.println(e.getMessage());
            }
            list.set(i, new C8_DanhBa(list.get(i).getId(), getContactInformation().getName(), getContactInformation().getNumber()));
            c8DanhBaAdapter.notifyDataSetChanged();
        }
    }

    @Override
    public void DeleteDatabase(int i) {
        try {
            // Xác định bảng và điều kiện xóa
            String tableName = "info"; // Thay "info" bằng tên bảng của bạn
            String whereClause = "id = ?"; // Sử dụng tên cột ID của bạn
            String[] whereArgs = {String.valueOf(list.get(i).getId())};

            // Thực hiện lệnh xóa
            database.delete(tableName, whereClause, whereArgs);
        } catch (Exception e) {
            // Xử lý lỗi nếu có
            Loi(e, "DeleteDatabase");
            System.out.println(e.getMessage());
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.c8_save_item, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == R.id.btnAdd) {
            AddDatabase();
        }
        return true;
    }

    private void AddDatabase() {
        try {
            C8_DanhBa c8DanhBa = getContactInformation();
            if (c8DanhBa == null) return;

            String sql = "insert into info (name, phone) values('" + c8DanhBa.getName() + "', '" + c8DanhBa.getNumber() + "')";
            database.execSQL(sql);

            // Lấy ID của phần tử vừa thêm vào
            Cursor cursor = database.rawQuery("SELECT last_insert_rowid()", null);
            int insertedId = -1;
            if (cursor.moveToFirst()) {
                insertedId = cursor.getInt(0);
            }
            cursor.close();
            list.add(new C8_DanhBa(insertedId, c8DanhBa.getName(), c8DanhBa.getNumber()));

            editName.setText("");
            editNumber.setText("");
            c8DanhBaAdapter.notifyDataSetChanged();
        } catch (Exception e) {
            Loi(e, "AddDatabase");
        }
    }

    private void Loi(Exception e, String title) {
        AlertDialog.Builder builder = new AlertDialog.Builder(C8_DanhBa_CSDL.this)
                .setTitle("Lỗi lớp chính, ở hàm " + title + ":")
                .setMessage(e.getMessage().trim())
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        dialogInterface.dismiss();
                    }
                });
        AlertDialog alertDialog = builder.create();
        alertDialog.show();
    }

}
