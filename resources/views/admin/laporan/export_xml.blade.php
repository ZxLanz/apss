<?php echo chr(60) . '?xml version="1.0"?' . chr(62); ?>
<?php echo chr(60) . '?mso-application progid="Excel.Sheet"?' . chr(62); ?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>APSS System</Author>
  <LastAuthor>APSS System</LastAuthor>
  <Created>{{ now()->toIso8601String() }}</Created>
  <Version>1.0</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>10000</WindowHeight>
  <WindowWidth>20000</WindowWidth>
  <WindowTopX>0</WindowTopX>
  <WindowTopY>0</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="sHeader">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
   </Borders>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="12" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#0058BE" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sTitle">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="16" ss:Color="#0058BE" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sData">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="10"/>
  </Style>
  <Style ss:ID="sDataCenter">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="10"/>
  </Style>
  <Style ss:ID="sStatusSelesai">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="10" ss:Color="#059669" ss:Bold="1"/>
  </Style>
  <Style ss:ID="sStatusProses">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Font ss:FontName="Poppins" x:Family="Swiss" ss:Size="10" ss:Color="#2563EB" ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Laporan">
  <Table ss:ExpandedColumnCount="11" ss:ExpandedRowCount="{{ $laporan->count() + 5 }}" x:FullColumns="1" x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:AutoFitWidth="0" ss:Width="100"/>
   <Column ss:AutoFitWidth="0" ss:Width="100"/>
   <Column ss:AutoFitWidth="0" ss:Width="150"/>
   <Column ss:AutoFitWidth="0" ss:Width="80"/>
   <Column ss:AutoFitWidth="0" ss:Width="120"/>
   <Column ss:AutoFitWidth="0" ss:Width="120"/>
   <Column ss:AutoFitWidth="0" ss:Width="200"/>
   <Column ss:AutoFitWidth="0" ss:Width="80"/>
   <Column ss:AutoFitWidth="0" ss:Width="120"/>
   <Column ss:AutoFitWidth="0" ss:Width="200"/>
   
   <Row ss:AutoFitHeight="0" ss:Height="30">
    <Cell ss:MergeAcross="10" ss:StyleID="sTitle"><Data ss:Type="String">LAPORAN PENGADUAN SARANA SEKOLAH (APSS)</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="20">
    <Cell ss:MergeAcross="10" ss:StyleID="sDataCenter"><Data ss:Type="String">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} WIB | Total: {{ $laporan->count() }} Data</Data></Cell>
   </Row>
   <Row ss:Index="4" ss:AutoFitHeight="0" ss:Height="25">
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">ID</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">TANGGAL</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">NIS</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">NAMA SISWA</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">KELAS</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">KATEGORI</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">LOKASI</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">KETERANGAN</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">STATUS</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">FEEDBACK</Data></Cell>
    <Cell ss:StyleID="sHeader"><Data ss:Type="String">ADMIN</Data></Cell>
   </Row>
   @foreach($laporan as $item)
   <Row ss:AutoFitHeight="1" ss:MinHeight="20">
    <Cell ss:StyleID="sDataCenter"><Data ss:Type="Number">{{ $item->id }}</Data></Cell>
    <Cell ss:StyleID="sDataCenter"><Data ss:Type="String">{{ $item->created_at->format('d/m/Y H:i:s') }}</Data></Cell>
    <Cell ss:StyleID="sDataCenter"><Data ss:Type="String">{{ $item->siswa->nis }}</Data></Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ strtoupper($item->siswa->nama) }}</Data></Cell>
    <Cell ss:StyleID="sDataCenter"><Data ss:Type="String">{{ $item->siswa->kelas }}</Data></Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ $item->kategori->nama_kategori }}</Data></Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ $item->lokasi }}</Data></Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ $item->ket }}</Data></Cell>
    <Cell ss:StyleID="{{ $item->aspirasi?->status == 'selesai' ? 'sStatusSelesai' : ($item->aspirasi?->status == 'proses' ? 'sStatusProses' : 'sDataCenter') }}">
        <Data ss:Type="String">{{ strtoupper($item->aspirasi?->status ?? 'menunggu') }}</Data>
    </Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ $item->aspirasi?->feedback_label ?? '-' }}</Data></Cell>
    <Cell ss:StyleID="sData"><Data ss:Type="String">{{ $item->aspirasi?->keterangan ?? '-' }}</Data></Cell>
   </Row>
   @endforeach
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>0</ActiveRow>
     <ActiveCol>0</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
