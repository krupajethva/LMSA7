import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImportfileDataComponent } from './importfile-data.component';

describe('ImportfileDataComponent', () => {
  let component: ImportfileDataComponent;
  let fixture: ComponentFixture<ImportfileDataComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImportfileDataComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImportfileDataComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
