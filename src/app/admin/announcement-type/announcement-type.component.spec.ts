import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AnnouncementTypeComponent } from './announcement-type.component';

describe('AnnouncementTypeComponent', () => {
  let component: AnnouncementTypeComponent;
  let fixture: ComponentFixture<AnnouncementTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AnnouncementTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AnnouncementTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
